<?php


namespace Symfony\Component\HttpKernel\Fragment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Controller\ControllerReference;


class FragmentHandler
{
    private $debug;
    private $renderers;
    private $request;

    /**
     * Constructor.
     *
     * @param FragmentRendererInterface[] $renderers An array of FragmentRendererInterface instances
     * @param bool                        $debug     Whether the debug mode is enabled or not
     */
    public function __construct(array $renderers = array(), $debug = false)
    {
        $this->renderers = array();
        foreach ($renderers as $renderer) {
            $this->addRenderer($renderer);
        }
        $this->debug = $debug;
    }

    /**
     * Adds a renderer.
     *
     * @param FragmentRendererInterface $renderer A FragmentRendererInterface instance
     */
    public function addRenderer(FragmentRendererInterface $renderer)
    {
        $this->renderers[$renderer->getName()] = $renderer;
    }

    /**
     * Sets the current Request.
     *
     * @param Request $request The current Request
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Renders a URI and returns the Response content.
     *
     * Available options:
     *
     *  * ignore_errors: true to return an empty string in case of an error
     *
     * @param string|ControllerReference $uri      A URI as a string or a ControllerReference instance
     * @param string                     $renderer The renderer name
     * @param array                      $options  An array of options
     *
     * @return string|null The Response content or null when the Response is streamed
     *
     * @throws \InvalidArgumentException when the renderer does not exist
     * @throws \LogicException           when no master request is being handled
     * @throws \RuntimeException         when the Response is not successful
     */
    public function render($uri, $renderer = 'inline', array $options = array())
    {
        if (!isset($options['ignore_errors'])) {
            $options['ignore_errors'] = !$this->debug;
        }

        if (!isset($this->renderers[$renderer])) {
            throw new \InvalidArgumentException(sprintf('The "%s" renderer does not exist.', $renderer));
        }

        if (null === $this->request) {
            throw new \LogicException('Rendering a fragment can only be done when handling a master Request.');
        }

        return $this->deliver($this->renderers[$renderer]->render($uri, $this->request, $options));
    }

    /**
     * Delivers the Response as a string.
     *
     * When the Response is a StreamedResponse, the content is streamed immediately
     * instead of being returned.
     *
     * @param Response $response A Response instance
     *
     * @return string|null The Response content or null when the Response is streamed
     *
     * @throws \RuntimeException when the Response is not successful
     */
    protected function deliver(Response $response)
    {
        if (!$response->isSuccessful()) {
            throw new \RuntimeException(sprintf('Error when rendering "%s" (Status code is %s).', $this->request->getUri(), $response->getStatusCode()));
        }

        if (!$response instanceof StreamedResponse) {
            return $response->getContent();
        }

        $response->sendContent();
    }
}