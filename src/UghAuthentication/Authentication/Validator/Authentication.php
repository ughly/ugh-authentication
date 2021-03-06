<?php

namespace UghAuthentication\Authentication\Validator;

use UghAuthentication\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Exception;
use Zend\Authentication\Result;
use Zend\Validator\AbstractValidator;

/**
 * Authentication Validator
 */
class Authentication extends AbstractValidator
{

    /**
     * Error codes
     * @const string
     */
    const IDENTITY_NOT_FOUND = 'identityNotFound';
    const IDENTITY_AMBIGUOUS = 'identityAmbiguous';
    const CREDENTIAL_INVALID = 'credentialInvalid';
    const UNCATEGORIZED = 'uncategorized';
    const GENERAL = 'general';

    /**
     * Error Messages
     * @var array
     */
    protected $messageTemplates = array(
        self::IDENTITY_NOT_FOUND => 'Invalid identity',
        self::IDENTITY_AMBIGUOUS => 'Identity is ambiguous',
        self::CREDENTIAL_INVALID => 'Invalid password',
        self::UNCATEGORIZED => 'Authentication failed',
        self::GENERAL => 'Authentication failed',
    );

    /**
     * Identity (or field)
     * @var string
     */
    protected $identity;

    /**
     * Credential (or field)
     * @var string
     */
    protected $credential;

    /**
     * Authentication Service
     * @var AuthenticationServiceInterface
     */
    protected $service;

    /**
     * Sets validator options
     *
     * @param mixed $options
     */
    public function __construct($options = null)
    {
        if (is_array($options)) {
            if (array_key_exists('identity', $options)) {
                $this->setIdentity($options['identity']);
            }
            if (array_key_exists('credential', $options)) {
                $this->setCredential($options['credential']);
            }
            if (array_key_exists('service', $options)) {
                $this->setService($options['service']);
            }
        }
        parent::__construct($options);
    }

    /**
     * Get Identity
     *
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set Identity
     *
     * @param  mixed          $identity
     * @return Authentication
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get Credential
     *
     * @return mixed
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * Set Credential
     *
     * @param  mixed          $credential
     * @return Authentication
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;

        return $this;
    }

    /**
     * Get Service
     *
     * @return AuthenticationService
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set Service
     *
     * @param  AuthenticationServiceInterface $service
     * @return Authentication
     */
    public function setService(AuthenticationServiceInterface $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Is Valid
     *
     * @param  mixed $value
     * @param  array $context
     * @return bool
     */
    public function isValid($value = null, $context = null)
    {
        if ($value !== null) {
            $this->setCredential($value);
        }

        if (($context !== null) && array_key_exists($this->identity, $context)) {
            $identity = $context[$this->identity];
        } else {
            $identity = $this->identity;
        }
        if (!$this->identity) {
            throw new Exception\RuntimeException('Identity must be set prior to validation');
        }

        if (($context !== null) && array_key_exists($this->credential, $context)) {
            $credential = $context[$this->credential];
        } else {
            $credential = $this->credential;
        }

        if (!$this->service) {
            throw new Exception\RuntimeException('AuthenticationService must be set prior to validation');
        }

        $this->service->setIdentity($identity);
        $this->service->setCredential($credential);

        $result = $this->service->authenticate();

        if ($result->getCode() != Result::SUCCESS) {
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    $this->error(self::IDENTITY_NOT_FOUND);
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    $this->error(self::CREDENTIAL_INVALID);
                    break;
                case Result::FAILURE_IDENTITY_AMBIGUOUS:
                    $this->error(self::IDENTITY_AMBIGUOUS);
                    break;
                case Result::FAILURE_UNCATEGORIZED:
                    $this->error(self::UNCATEGORIZED);
                    break;
                default:
                    $this->error(self::GENERAL);
            }
            return false;
        }

        return true;
    }
}
