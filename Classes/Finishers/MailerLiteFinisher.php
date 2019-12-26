<?php
namespace SimpleSolution\MailerLiteFinisher\Finishers;

use Neos\Form\Core\Model\AbstractFinisher;
use Neos\Form\Exception\FinisherException;
use MailerLiteApi\MailerLite;

/**
 * A finisher that adds a subscriber to the MailerLite newsletter software
 *
 * Options:
 *
 * - APIKey: The API key of the MailerLite account
 * - groupID: The group ID of the newsletter group in the MailerLite account
 * - variables.*: The variables of the subscriber (variables.email is required, others are optional)
 *
 * Usage:
 * //...
 * $mailerLiteFinisher = new \SimpleSolution\MailerLiteFinisher\Finishers\MailerLiteFinisher();
 * $mailerLiteFinisher->setOptions(
 *   array(
 *     'APIKey' => '123456789',
 *     'groupID' => '123456789',
 *   )
 * );
 * $formDefinition->addFinisher($mailerLiteFinisher);
 * // ...
 */
class MailerLiteFinisher extends AbstractFinisher
{
    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     *
     * @return void
     * @throws FinisherException
     */

    protected $defaultOptions = array(
        'APIKey' => null,
        'groupID' => null,
        'variables.email' => null,
        'variables.firstname' => null,
        'variables.lastname' => null,
        'variables.company' => null,
        'variables.country' => null,
        'variables.city' => null,
        'variables.phone' => null,
        'variables.state' => null,
        'variables.zip' => null,
    );

    protected function executeInternal()
    {
        // Required options
        $apiKey = $this->parseOption('APIKey');
        $groupId = $this->parseOption('groupID');
        $email = $this->parseOption('variables.email');

        // Optional fields
        $firstname = $this->parseOption('variables.firstname');
        $lastname = $this->parseOption('variables.lastname');
        $company = $this->parseOption('variables.company');
        $country = $this->parseOption('variables.country');
        $city = $this->parseOption('variables.city');
        $phone = $this->parseOption('variables.phone');
        $state = $this->parseOption('variables.state');
        $zip = $this->parseOption('variables.zip');

        if ($apiKey === null) {
            throw new FinisherException('The option "APIKey" must be set for the MailerLiteFinisher.');
        }
        if ($groupId === null) {
            throw new FinisherException('The option "groupID" must be set for the MailerLiteFinisher.');
        }
        if ($email === null) {
            throw new FinisherException('The option "variables.email" must be set for the MailerLiteFinisher.');
        }

        if($apiKey && $groupId && $firstname && $lastname && $email) {
            $groupsApi = (new \MailerLiteApi\MailerLite($apiKey))->groups();

            $subscriber = [
                'email' => $email,
                'name' => $firstname,
                'fields' => [
                    'last_name' => $lastname,
                    'company' => $company,
                    'country' => $country,
                    'city' => $city,
                    'phone' => $phone,
                    'state' => $state,
                    'zip' => $zip
                ]
            ];

            $groupsApi->addSubscriber($groupId, $subscriber);
        }
    }
}
