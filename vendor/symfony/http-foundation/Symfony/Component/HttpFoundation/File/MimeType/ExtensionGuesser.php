<?php


namespace Symfony\Component\HttpFoundation\File\MimeType;

class ExtensionGuesser implements ExtensionGuesserInterface
{
    /**
     * The singleton instance
     *
     * @var ExtensionGuesser
     */
    private static $instance = null;

    /**
     * All registered ExtensionGuesserInterface instances
     *
     * @var array
     */
    protected $guessers = array();

    /**
     * Returns the singleton instance
     *
     * @return ExtensionGuesser
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Registers all natively provided extension guessers
     */
    private function __construct()
    {
        $this->register(new MimeTypeExtensionGuesser());
    }

    /**
     * Registers a new extension guesser
     *
     * When guessing, this guesser is preferred over previously registered ones.
     *
     * @param ExtensionGuesserInterface $guesser
     */
    public function register(ExtensionGuesserInterface $guesser)
    {
        array_unshift($this->guessers, $guesser);
    }

    /**
     * Tries to guess the extension
     *
     * The mime type is passed to each registered mime type guesser in reverse order
     * of their registration (last registered is queried first). Once a guesser
     * returns a value that is not NULL, this method terminates and returns the
     * value.
     *
     * @param string $mimeType The mime type
     *
     * @return string          The guessed extension or NULL, if none could be guessed
     */
    public function guess($mimeType)
    {
        foreach ($this->guessers as $guesser) {
            if (null !== $extension = $guesser->guess($mimeType)) {
                return $extension;
            }
        }
    }
}