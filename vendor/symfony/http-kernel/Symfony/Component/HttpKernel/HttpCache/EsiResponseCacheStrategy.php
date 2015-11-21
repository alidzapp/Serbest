<?php


namespace Symfony\Component\HttpKernel\HttpCache;

use Symfony\Component\HttpFoundation\Response;

class EsiResponseCacheStrategy implements EsiResponseCacheStrategyInterface
{
    private $cacheable = true;
    private $embeddedResponses = 0;
    private $ttls = array();
    private $maxAges = array();

    /**
     * {@inheritdoc}
     */
    public function add(Response $response)
    {
        if ($response->isValidateable()) {
            $this->cacheable = false;
        } else {
            $this->ttls[] = $response->getTtl();
            $this->maxAges[] = $response->getMaxAge();
        }

        $this->embeddedResponses++;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Response $response)
    {
        // if we have no embedded Response, do nothing
        if (0 === $this->embeddedResponses) {
            return;
        }

        // Remove validation related headers in order to avoid browsers using
        // their own cache, because some of the response content comes from
        // at least one embedded response (which likely has a different caching strategy).
        if ($response->isValidateable()) {
            $response->setEtag(null);
            $response->setLastModified(null);
            $this->cacheable = false;
        }

        if (!$this->cacheable) {
            $response->headers->set('Cache-Control', 'no-cache, must-revalidate');

            return;
        }

        $this->ttls[] = $response->getTtl();
        $this->maxAges[] = $response->getMaxAge();

        if (null !== $maxAge = min($this->maxAges)) {
            $response->setSharedMaxAge($maxAge);
            $response->headers->set('Age', $maxAge - min($this->ttls));
        }
        $response->setMaxAge(0);
    }
}
