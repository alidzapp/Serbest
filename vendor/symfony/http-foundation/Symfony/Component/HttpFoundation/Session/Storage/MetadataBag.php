<?php


namespace Symfony\Component\HttpFoundation\Session\Storage;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;


class MetadataBag implements SessionBagInterface
{
    const CREATED = 'c';
    const UPDATED = 'u';
    const LIFETIME = 'l';

    /**
     * @var string
     */
    private $name = '__metadata';

    /**
     * @var string
     */
    private $storageKey;

    /**
     * @var array
     */
    protected $meta = array();

    /**
     * Unix timestamp.
     *
     * @var int
     */
    private $lastUsed;

    /**
     * Constructor.
     *
     * @param string $storageKey The key used to store bag in the session.
     */
    public function __construct($storageKey = '_sf2_meta')
    {
        $this->storageKey = $storageKey;
        $this->meta = array(self::CREATED => 0, self::UPDATED => 0, self::LIFETIME => 0);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array &$array)
    {
        $this->meta = &$array;

        if (isset($array[self::CREATED])) {
            $this->lastUsed = $this->meta[self::UPDATED];
            $this->meta[self::UPDATED] = time();
        } else {
            $this->stampCreated();
        }
    }

    /**
     * Gets the lifetime that the session cookie was set with.
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->meta[self::LIFETIME];
    }

    /**
     * Stamps a new session's metadata.
     *
     * @param int     $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                          will leave the system settings unchanged, 0 sets the cookie
     *                          to expire with browser session. Time is in seconds, and is
     *                          not a Unix timestamp.
     */
    public function stampNew($lifetime = null)
    {
        $this->stampCreated($lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /**
     * Gets the created timestamp metadata.
     *
     * @return int     Unix timestamp
     */
    public function getCreated()
    {
        return $this->meta[self::CREATED];
    }

    /**
     * Gets the last used metadata.
     *
     * @return int     Unix timestamp
     */
    public function getLastUsed()
    {
        return $this->lastUsed;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        // nothing to do
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    private function stampCreated($lifetime = null)
    {
        $timeStamp = time();
        $this->meta[self::CREATED] = $this->meta[self::UPDATED] = $this->lastUsed = $timeStamp;
        $this->meta[self::LIFETIME] = (null === $lifetime) ? ini_get('session.cookie_lifetime') : $lifetime;
    }
}
