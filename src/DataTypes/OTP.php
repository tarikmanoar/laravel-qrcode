<?php

namespace Manoar\QrCode\DataTypes;

use InvalidArgumentException;

class OTP implements DataTypeInterface
{
    protected string $type = 'totp';
    protected string $label = '';
    protected string $secret = '';
    protected string $issuer = '';
    protected int $digits = 6;
    protected int $period = 30;
    protected int $counter = 0;
    protected string $algorithm = 'SHA1';

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * Accepts a single associative array with keys:
     *   type    – 'totp' (default) or 'hotp'
     *   label   – Account label, e.g. 'user@example.com' (required)
     *   secret  – Base32-encoded secret key (required)
     *   issuer  – Issuer name, e.g. 'MyApp'
     *   digits  – Number of OTP digits (6 or 8, default 6)
     *   period  – TOTP period in seconds (default 30)
     *   counter – HOTP counter value (default 0)
     *   algorithm – Hash algorithm: SHA1, SHA256, SHA512 (default SHA1)
     *
     * @param array $arguments
     * @throws InvalidArgumentException
     */
    public function create(array $arguments)
    {
        $args = $arguments[0] ?? $arguments;

        if (empty($args['label'])) {
            throw new InvalidArgumentException('OTP QR code requires a label.');
        }
        if (empty($args['secret'])) {
            throw new InvalidArgumentException('OTP QR code requires a secret.');
        }

        $this->label = $args['label'];
        $this->secret = strtoupper($args['secret']);

        if (isset($args['type'])) {
            $type = strtolower($args['type']);
            if (! in_array($type, ['totp', 'hotp'])) {
                throw new InvalidArgumentException("OTP type must be 'totp' or 'hotp'.");
            }
            $this->type = $type;
        }

        if (isset($args['issuer'])) {
            $this->issuer = $args['issuer'];
        }
        if (isset($args['digits'])) {
            $this->digits = (int) $args['digits'];
        }
        if (isset($args['period'])) {
            $this->period = (int) $args['period'];
        }
        if (isset($args['counter'])) {
            $this->counter = (int) $args['counter'];
        }
        if (isset($args['algorithm'])) {
            $this->algorithm = strtoupper($args['algorithm']);
        }
    }

    /**
     * Returns the otpauth URI string.
     *
     * @return string
     */
    public function __toString()
    {
        $label = rawurlencode($this->label);

        $params = [
            'secret'    => $this->secret,
            'issuer'    => $this->issuer,
            'algorithm' => $this->algorithm,
            'digits'    => $this->digits,
        ];

        if ($this->type === 'totp') {
            $params['period'] = $this->period;
        } else {
            $params['counter'] = $this->counter;
        }

        // Remove empty optional values
        $params = array_filter($params, fn ($v) => $v !== '' && $v !== null);

        return 'otpauth://'.$this->type.'/'.$label.'?'.http_build_query($params);
    }
}
