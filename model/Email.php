<?php
namespace Epi_Model;

class Email 
{
	private $_objectEmail;
	private $_toEmail;
	private $_bodyEmail;

	public function __construct($object, $to, $body)
    {  
    	$this->_objectEmail = $object;
    	$this->_toEmail 	= $to;
    	$this->_bodyEmail	= $body;
    }

    public function transportEmail()
    {
    	// Create the Transport
		$transport = (new \Swift_SmtpTransport('smtp.webmo.fr', 587))
		  ->setUsername('epi@pass-sport-nature.fr')
		  ->setPassword('19SpotsWeb20*');
		return $transport;
    }

    public function messageEmail()
    {
    	// Create a message
    	$message = new \Swift_Message();
		$message->setSubject($this->_objectEmail);
		$message->setFrom(['epi@pass-sport-nature.fr' => 'Gestion EPI - Pass\'Sport Nature']);
		$message->setTo($this->_toEmail);
		$message->setBody($this->_bodyEmail, 'text/html');

		return $message;
	}

	public function sendEmail()
	{
		// Create the Mailer using your created Transport
		$mailer = new \Swift_Mailer($this->transportEmail());
		// Send the message
		$mailer->send($this->messageEmail());
	}
}