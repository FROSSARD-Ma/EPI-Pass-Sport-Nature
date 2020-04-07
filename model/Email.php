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

    public function htmlEmail()
    {
		$htmlEmail = "
            <style type='text/css'>
                * {
                  margin:0;
                  padding:0;
                }

                body {
                  background:#F4F4F4;
                  text-align: center;
                }

                p { 
                  font-size:12px;
                  font-family:Arial, Verdana;
                }

                a, a:visited { text-decoration:none;}
                a:hover, a:focus {text-decoration:none;}
                a:link  {text-decoration:none;}
                a:active  {text-decoration:none;}


                .box {
                    width: 90%;
                    margin-right:auto;
                    margin-left:auto;
                    margin-top: 50px;
                    background-color: white;
                    text-align: left;
                }

                h1 {
                    font-family: Arial, Verdana, Helvetica, sans-serif;
                    font-size: 16;
                    color: #FFF;
                    text-align:center;
                    background-color: #EC8813;
                    padding: 5px;
                    margin: 5px;
                }
                h2 {
                	font-family: Arial, Verdana, Helvetica, sans-serif;
                    font-size: 14;
                	color: #EC8813;
                	text-align:left;
                }

                .retrait {
                    margin-left:30px;
                }

                .bouton_inscription_D {
                    background: #EC8813;
                    margin: 5px;
                    padding:2px 3px 2px 3px;
                    width:auto;
                    max-width: 150px;
                    font-size:14px;
                    font-family:Arial, Verdana;
                    color: #FFF;
                    text-align: center;
                    float: right;

                    /* Rounded Corners 
                    -moz-border-radius: 5px;
                    -webkit-border-radius: 5px;
                    -khtml-border-radius: 5px;
                    border-radius: 5px;
                }
            </style>

			<html lang='fr'>
			    <head>
			        <meta http-equiv='Content-type' content='text/html; charset=UTF-8'/>
			    </head>
			    <body>
			        <img src='https://epi.pass-sport-nature.fr/public/img/banniere-email.png'/>
			        <h1>Gestion des Équipements de Protection Individuelle - EPI</h1>
			        <div class='box'>
			            <div class='retrait'>
			                <br><br>
			                ". $this->_bodyEmail ."
			                <br>
			                <p>Cette information est un courrier automatique pour toutes demandes vous pouvez répondre à cet eMail</p>
                            <p>Merci</p>
                            <p>Marie de Pass'Sport Nature</p>
			                <br><br>
				        </div>
				    </div>
				</body>
			</html>";

		return $htmlEmail;
    }

    public function messageEmail()
    {
    	// Create a message
    	$message = new \Swift_Message();
		$message->setSubject($this->_objectEmail);
		$message->setFrom(['epi@pass-sport-nature.fr' => 'Gestion EPI - Pass\'Sport Nature']);
		$message->setTo($this->_toEmail);
		$message->setBody($this->htmlEmail(), 'text/html');

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