<?php

namespace Manoar\QrCode\DataTypes;

use InvalidArgumentException;

class WhatsApp implements DataTypeInterface
{
    protected string $phone = '';
    protected string $message = '';

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * Usage: QrCode::whatsApp('+1234567890', 'Hello!')
     *   or:  QrCode::whatsApp(['+1234567890', 'Hello!'])
     *
     * @param array $arguments
     */
    public function create(array $arguments)
    {
        if (isset($arguments[0]) && is_array($arguments[0])) {
            $arguments = $arguments[0];
        }

        if (isset($arguments[0])) {
            $this->phone = preg_replace('/[^0-9+]/', '', (string) $arguments[0]);
        }

        if (isset($arguments[1])) {
            $this->message = (string) $arguments[1];
        }
    }

    /**
     * Returns the WhatsApp deep-link URL string.
     *
     * @return string
     */
    public function __toString()
    {
        $url = 'https://wa.me/'.ltrim($this->phone, '+');

        if ($this->message !== '') {
            $url .= '?text='.rawurlencode($this->message);
        }

        return $url;
    }
}
