<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Voice;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Voice\V1\DialingPermissionsList;
use Twilio\Version;

/**
 * @property \Twilio\Rest\Voice\V1\DialingPermissionsList dialingPermissions
 */
class V1 extends Version {
    protected $_dialingPermissions = null;

    /**
     * Construct the V1 version of Voice
     * 
     * @param \Twilio\Domain $domain Domain that contains the version
     * @return \Twilio\Rest\Voice\V1 V1 version of Voice
     */
    public function __construct(Domain $domain) {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    /**
     * @return \Twilio\Rest\Voice\V1\DialingPermissionsList 
     */
    protected function getDialingPermissions() {
        if (!$this->_dialingPermissions) {
            $this->_dialingPermissions = new DialingPermissionsList($this);
        }
        return $this->_dialingPermissions;
    }

    /**
     * Magic getter to lazy load root resources
     * 
     * @param string $name Resource to return
     * @return \Twilio\ListResource The requested resource
     * @throws \Twilio\Exceptions\TwilioException For unknown resource
     */
    public function __get($name) {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new TwilioException('Unknown resource ' . $name);
    }

    /**
     * Magic caller to get resource contexts
     * 
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return \Twilio\InstanceContext The requested resource context
     * @throws \Twilio\Exceptions\TwilioException For unknown resource
     */
    public function __call($name, $arguments) {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }

        throw new TwilioException('Resource does not have a context');
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Voice.V1]';
    }
}