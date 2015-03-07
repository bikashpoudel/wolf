<?php

/**
 * *  ____  _____ _     ____
 * * /  _ \/  __// \ |\/_   \
 * * | | \||  \  | | // /   /
 * * | |_/||  /_ | \// /   /_
 * * \____/\____\\__/  \____/
 * *
 * * @author Bikash Poudel <bikash.poudel.com@gmail.com>
 * * © 2013-2014 Dev2Digital Ltd.
 * */
namespace User\Entity;

use Wolf\Entity\AbstractEntity;

/**
 * Description of User
 */
class User extends AbstractEntity
{

	//gender constants
	const GENDER_MALE      = 'male';
	const GENDER_FEMALE    = 'female';
	const GENDER_UNDEFINED = 'undefined';

	//status constants
	const STATUS_ACTIVE   = 'active';
	const STATUS_PENDING  = 'pending';
	const STATUS_INACTIVE = 'inactive';
	const STATUS_DELETED  = 'deleted';

	const ACCOUNT_GUEST = 'guest';

	/**
	 * Id
	 *
	 * @var int
	 */
	public $id;

	/**
	 * Username
	 *
	 * @var string
	 */
	public $username;

	/**
	 * Email
	 *
	 * @var string
	 */
	public $email;

	/**
	 * Prefix
	 *
	 * @var string
	 */
	public $prefix;

	/**
	 * Firstname
	 *
	 * @var string
	 */
	public $firstName;

	/**
	 * Middlename
	 *
	 * @var string
	 */
	public $middleName;

	/**
	 * Lastname
	 *
	 * @var string
	 */
	public $lastName;

	/**
	 * Gender
	 *
	 * @var string
	 */
	public $gender;

	/**
	 * Date of birth
	 *
	 * @var string
	 */
	public $dateOfBirth;

	/**
	 * Company
	 *
	 * @var string
	 */
	public $company;

	/**
	 * Locale
	 *
	 * @var string
	 */
	public $locale;

	/**
	 * Timezone
	 *
	 * @var string
	 */
	public $timezone;

	/**
	 * Status
	 *
	 * @var string
	 */
	public $status;

	/**
	 * Profile picture
	 *
	 * @var string
	 */
	public $profilePicture;

	/**
	 * Email mailing list
	 *
	 * @var string
	 */
	public $emailMailingList;

	/**
	 * Mobile mailing list
	 *
	 * @var string
	 */
	public $mobileMailingList;

	/**
	 * Terms accepted
	 *
	 * @var string
	 */
	public $termsAccepted;

	/**
	 * Failed login count
	 *
	 * @var int
	 */
	public $failedLoginCount;

	/**
	 * Date added
	 *
	 * @var string
	 */
	public $dateAdded;

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Get prefix
	 *
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * Get first name
	 *
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * Get middle name
	 *
	 * @return string
	 */
	public function getMiddleName()
	{
		return $this->middleName;
	}

	/**
	 * Get last name
	 *
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * Get gender
	 *
	 * @return string
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * Get date of birth
	 *
	 * @return string
	 */
	public function getDateOfBirth()
	{
		return $this->dateOfBirth;
	}

	/**
	 * Get company
	 *
	 * @return string
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
	 * Get locale
	 *
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * Get timezone
	 *
	 * @return string
	 */
	public function getTimezone()
	{
		return $this->timezone;
	}

	/**
	 * Get status
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Get profile picture
	 *
	 * @return string
	 */
	public function getProfilePicture()
	{
		return $this->profilePicture;
	}

	/**
	 * Get email mailing list
	 *
	 * @return string
	 */
	public function getEmailMailingList()
	{
		return $this->emailMailingList;
	}

	/**
	 * Get terms accepted
	 *
	 * @return string
	 */
	public function getTermsAccepted()
	{
		return $this->termsAccepted;
	}

	/**
	 * Get failied login count
	 *
	 * @return string
	 */
	public function getFailedLoginCount()
	{
		return $this->failedLoginCount;
	}

	/**
	 * Get date added
	 *
	 * @return string
	 */
	public function getDateAdded()
	{
		return $this->dateAdded;
	}

	/**
	 * Set id
	 *
	 * @param int $id
	 * @return \Wolf\Entity\User
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 * @return \Wolf\Entity\User
	 */
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return \Wolf\Entity\User
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * Set prefix
	 *
	 * @param string $prefix
	 * @return \Wolf\Entity\User
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
		return $this;
	}

	/**
	 *
	 * @param string $firstName
	 * @return \Wolf\Entity\User
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
		return $this;
	}

	/**
	 *
	 * @param string $middleName
	 * @return \Wolf\Entity\User
	 */
	public function setMiddleName($middleName)
	{
		$this->middleName = $middleName;
		return $this;
	}

	/**
	 *
	 * @param string $lastName
	 * @return \Wolf\Entity\User
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}

	/**
	 *
	 * @param string $gender
	 * @return \Wolf\Entity\User
	 */
	public function setGender($gender)
	{
		$this->gender = $gender;
		return $this;
	}

	/**
	 *
	 * @param string $dateOfBirth
	 * @return \Wolf\Entity\User
	 */
	public function setDateOfBirth($dateOfBirth)
	{
		$this->dateOfBirth = $dateOfBirth;
		return $this;
	}

	/**
	 *
	 * @param string $company
	 * @return \Wolf\Entity\User
	 */
	public function setCompany($company)
	{
		$this->company = $company;
		return $this;
	}

	/**
	 *
	 * @param string $locale
	 * @return \Wolf\Entity\User
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;
		return $this;
	}

	/**
	 *
	 * @param string $timezone
	 * @return \Wolf\Entity\User
	 */
	public function setTimezone($timezone)
	{
		$this->timezone = $timezone;
		return $this;
	}

	/**
	 *
	 * @param string $status
	 * @return \Wolf\Entity\User
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	/**
	 *
	 * @param string $profilePicture
	 * @return \Wolf\Entity\User
	 */
	public function setProfilePicture($profilePicture)
	{
		$this->profilePicture = $profilePicture;
		return $this;
	}

	/**
	 *
	 * @param string $emailMailingList
	 * @return \Wolf\Entity\User
	 */
	public function setEmailMailingList($emailMailingList)
	{
		$this->emailMailingList = $emailMailingList;
		return $this;
	}

	/**
	 *
	 * @param int $termsAccepted
	 * @return \Wolf\Entity\User
	 */
	public function setTermsAccepted($termsAccepted)
	{
		$this->termsAccepted = $termsAccepted;
		return $this;
	}

	/**
	 *
	 * @param int $failedLoginCount
	 * @return \Wolf\Entity\User
	 */
	public function setFailedLoginCount($failedLoginCount)
	{
		$this->failedLoginCount = $failedLoginCount;
		return $this;
	}

	/**
	 *
	 * @param string $dateAdded
	 * @return \Wolf\Entity\User
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;
		return $this;
	}

	/**
	 * Set mobile mailing list
	 *
	 * @param type $mobileMailingList
	 * @return \User\Entity\User
	 */
	public function setMobileMailingList($mobileMailingList)
	{
		$this->mobileMailingList = $mobileMailingList;
		return $this;
	}

	/**
	 * Set values
	 *
	 * @param array $values
	 * @return \Wolf\Entity\User
	 */
	public function setValues(array $values = [])
	{
		if (isset($values['company'])) {
			$this->company = $values['company'];
		}

		if (isset($values['dateAdded'])) {
			$this->dateAdded = $values['dateAdded'];
		}

		if (isset($values['dateOfBirth'])) {
			$this->dateOfBirth = $values['dateOfBirth'];
		}

		if (isset($values['email'])) {
			$this->email = $values['email'];
		}

		if (isset($values['emailMailingList'])) {
			$this->emailMailingList = $values['emailMailingList'];
		}

		if (isset($values['failedLoginCount'])) {
			$this->failedLoginCount = $values['failedLoginCount'];
		}

		if (isset($values['firstName'])) {
			$this->firstName = $values['firstName'];
		}

		if (isset($values['gender'])) {
			$this->gender = $values['gender'];
		}

		if (isset($values['id'])) {
			$this->id = $values['id'];
		}

		if (isset($values['lastName'])) {
			$this->lastName = $values['lastName'];
		}

		if (isset($values['locale'])) {
			$this->locale = $values['locale'];
		}

		if (isset($values['middleName'])) {
			$this->middleName = $values['middleName'];
		}

		if (isset($values['prefix'])) {
			$this->prefix = $values['prefix'];
		}

		if (isset($values['profilePicture'])) {
			$this->profilePicture = $values['profilePicture'];
		}

		if (isset($values['status'])) {
			$this->status = $values['status'];
		}

		if (isset($values['termsAccepted'])) {
			$this->termsAccepted = $values['termsAccepted'];
		}

		if (isset($values['timezone'])) {
			$this->timezone = $values['timezone'];
		}

		if (isset($values['username'])) {
			$this->username = $values['username'];
		}

		if (isset($values['mobileMailingList'])) {
			$this->mobileMailingList = $values['mobileMailingList'];
		}

		return $this;
	}
}

