<?php

namespace Manoar\QrCode\DataTypes;

class MeCard implements DataTypeInterface
{
    protected string $firstName = '';
    protected string $lastName = '';
    protected string $phone = '';
    protected string $email = '';
    protected string $address = '';
    protected string $url = '';
    protected string $note = '';
    protected string $birthday = '';

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * Accepts a single associative array with keys:
     *   first_name, last_name, name (alias), phone, email,
     *   address, url, note, birthday (YYYYMMDD).
     *
     * @param array $arguments
     */
    public function create(array $arguments)
    {
        $args = $arguments[0] ?? $arguments;

        if (isset($args['name'])) {
            $parts = explode(' ', $args['name'], 2);
            $this->firstName = $parts[0] ?? '';
            $this->lastName = $parts[1] ?? '';
        }
        if (isset($args['first_name'])) {
            $this->firstName = $args['first_name'];
        }
        if (isset($args['last_name'])) {
            $this->lastName = $args['last_name'];
        }
        if (isset($args['phone'])) {
            $this->phone = $args['phone'];
        }
        if (isset($args['email'])) {
            $this->email = $args['email'];
        }
        if (isset($args['address'])) {
            $this->address = $args['address'];
        }
        if (isset($args['url'])) {
            $this->url = $args['url'];
        }
        if (isset($args['note'])) {
            $this->note = $args['note'];
        }
        if (isset($args['birthday'])) {
            $this->birthday = $args['birthday'];
        }
    }

    /**
     * Returns the MeCard formatted string.
     *
     * @return string
     */
    public function __toString()
    {
        $fullName = trim("{$this->lastName},{$this->firstName}");

        $parts = ['MECARD:N:'.$fullName];

        if ($this->phone !== '') {
            $parts[] = 'TEL:'.$this->phone;
        }
        if ($this->email !== '') {
            $parts[] = 'EMAIL:'.$this->email;
        }
        if ($this->address !== '') {
            $parts[] = 'ADR:'.$this->address;
        }
        if ($this->url !== '') {
            $parts[] = 'URL:'.$this->url;
        }
        if ($this->note !== '') {
            $parts[] = 'NOTE:'.$this->note;
        }
        if ($this->birthday !== '') {
            $parts[] = 'BDAY:'.$this->birthday;
        }

        return implode(';', $parts).';;';
    }
}
