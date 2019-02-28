<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 22:12
 */

namespace SittingPlan\Models;

class Person extends CollectionElement
{
    /**
     * @var string
     */
    protected $Title;
    /**
     * @var string
     */
    protected $FirstName;
    /**
     * @var string
     */
    protected $NameAddition;
    /**
     * @var string
     */
    protected $LastName;
    /**
     * @var string
     */
    protected $LdapUser;

    /**
     * @var string
     */
    protected $FullInfoString;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->Title;
    }

    /**
     * @param $value
     */
    public function setTitle($value): void
    {
        $this->Title = $value;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    /**
     * @param $value
     */
    public function setFirstName($value): void
    {
        $this->FirstName = $value;
    }

    /**
     * @return string
     */
    public function getNameAddition(): ?string
    {
        return $this->NameAddition;
    }

    /**
     * @param $value
     */
    public function setNameAddition($value): void
    {
        $this->NameAddition = $value;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    /**
     * @param $value
     */
    public function setLastName($value): void
    {
        $this->LastName = $value;
    }

    /**
     * @return string
     */
    public function getLdapUser(): ?string
    {
        return $this->LdapUser;
    }

    /**
     * @param $value
     */
    public function setLdapUser($value): void
    {
        $this->LdapUser = $value;
    }

    /**
     * @return string
     */
    public function getFullInfoString(): ?string
    {
        return $this->FullInfoString;
    }

    /**
     * @param $value
     */
    public function setFullInfoString($value): void
    {
        $this->FullInfoString = $value;
    }

    /**
     * @param string $fullInfoString
     */
    public function setPersonDataFromString(string $fullInfoString): void
    {
        $this->setFullInfoString($fullInfoString);
        $parsedData = $this->parsePersonData($fullInfoString);
        $this->setValuesFromArray($parsedData);
    }

    /**
     * @param string $fullInfoString
     * @return array
     */
    public function parsePersonData(string $fullInfoString = ''): array
    {
        if (empty($fullInfoString)) {
            return [];
        }
        // Pattern: ggf. Titel Vorname ggf. Zweitname(n) ggf. Namenszusatz Nachname (LDAP-Username)
        $pattern = '/^(?<title>Dr\.)?\s*(?<firstName>(\b(?!(van|von|de)\b)\S+\s*)+)\s+(?<nameAddition>van|von|de)?\s*(?<lastName>\S+)\s+\((?<ldapUser>\S+)\)$/i';
        preg_match($pattern, $fullInfoString, $matches);
        return $matches;
    }
}