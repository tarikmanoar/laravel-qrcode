<?php

namespace Manoar\QrCode\DataTypes;

class VCard implements DataTypeInterface
{
    protected string $firstName = '';
    protected string $lastName = '';
    protected string $phone = '';
    protected string $email = '';
    protected string $company = '';
    protected string $title = '';
    protected string $address = '';
    protected string $url = '';
    protected string $note = '';

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * Accepts a single associative array with keys:
     *   first_name, last_name, name (alias), phone, email,
     *   company, title, address, url, note.
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
        if (isset($args['company'])) {
            $this->company = $args['company'];
        }
        if (isset($args['title'])) {
            $this->title = $args['title'];
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
    }

    /**
     * Returns the vCard 3.0 formatted string.
     *
     * @return string
     */
    public function __toString()
    {
        $lines = ['BEGIN:VCARD', 'VERSION:3.0'];

        $fullName = trim("{$this->firstName} {$this->lastName}");
        $lines[] = 'N:'.($this->lastName).';'.($this->firstName).';;;';
        $lines[] = 'FN:'.($fullName ?: ($this->company ?: 'Unknown'));

        if ($this->company !== '') {
            $lines[] = 'ORG:'.$this->company;
        }
        if ($this->title !== '') {
            $lines[] = 'TITLE:'.$this->title;
        }
        if ($this->phone !== '') {
            $lines[] = 'TEL;TYPE=CELL:'.$this->phone;
        }
        if ($this->email !== '') {
            $lines[] = 'EMAIL:'.$this->email;
        }
        if ($this->address !== '') {
            $lines[] = 'ADR;TYPE=WORK:;;'.$this->address.';;;;';
        }
        if ($this->url !== '') {
            $lines[] = 'URL:'.$this->url;
        }
        if ($this->note !== '') {
            $lines[] = 'NOTE:'.$this->note;
        }

        $lines[] = 'END:VCARD';

        return implode("\n", $lines);
    }
}
