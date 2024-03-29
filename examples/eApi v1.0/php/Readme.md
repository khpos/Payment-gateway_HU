Requirements: 
- installed php 8

1. download and unzip or clone git repository with java plugin for K&H payment gateway
   (https://github.com/khpos/Payment-Gateway_EN)

2. goto current directory where composer.json is located and run "php .\composer.phar update"

3. configure src/examples.php
   a. setup url of K&H payment gateway for given environment, i.e. for integration environment set to value
      API_URL='https://api.sandbox.khpos.hu/api/v1.0'

   b. setup path to public key of K&H payment gateway, e.g.
      MIPS_PUBLIC_KEY_FILENAME='./config/mips_pay.sandbox.khpos.hu.pub'

   c. setup merchant ID (assigned by K&H), e.g.
      MERCHANT_ID='M1MIPSXXXX'

   d. setup path to merchant private key (key generated by https://pay.sandbox.khpos.hu/keygen tool), e.g.
      PRIVATE_KEY_FILE='./config/M1MIPSXXXX.key'

4. for others operations use following params ...

	#### echo via POST method

	   php .\src\examples.php -m ECHO_POST

   #### echo via GET method

       php .\src\examples.php -m ECHO_GET    

	#### payment init (standard payment)

	   php .\src\examples.php -m PAYMENT_INIT -i config/payment-init-base.json

	#### payment init (oneclick template)

	   php .\src\examples.php -m PAYMENT_INIT -i config/payment-init-oneclick-base.json

	#### payment process

	   php .\src\examples.php -m PAYMENT_PROCESS -p <pay-id-from-previous-payment-init-call>

	#### payment status

	   php .\src\examples.php -m PAYMENT_STATUS -p <pay-id-from-previous-payment-init-call>

	#### payment close

	   php .\src\examples.php -m PAYMENT_CLOSE -p <pay-id-from-previous-payment-init-call>

	  or for close to lower amount use -a param to specify totalAmount for payment/close:

	   php .\src\examples.php -m PAYMENT_CLOSE -p <pay-id-from-previous-payment-init-call> -a 1000

	#### payment reverse

	   php .\src\examples.php -m PAYMENT_REVERSE -p <pay-id-from-previous-payment-init-call>

	#### payment refund

	   php .\src\examples.php -m PAYMENT_REFUND -p <pay-id-from-previous-payment-init-call>

	  or for partial refund use -a param to specify amount for partial refund:

	   php .\src\examples.php -m PAYMENT_REFUND -p <pay-id-from-previous-payment-init-call> -a 1000

	#### oneclick echo

	   php .\src\examples.php -m ONECLICK_ECHO -x <orig-pay-id>

	#### oneclick init

	   php .\src\examples.php -m ONECLICK_INIT -i config/oneclick-init-base.json

	#### oneclick process

	   php .\src\examples.php -m  ONECLICK_PROCESS -p <pay-id-from-previous-oneclick-init-call>

	#### echo customer 

	   php .\src\examples.php -m ECHO_CUSTOMER -c <customer-id>

   #### applepay echo

       php .\src\examples.php -m APPLEPAY_ECHO
          
   #### applepay init

       php .\src\examples.php -m APPLEPAY_INIT -i config/applepay-init-base.json -t <base64 encoded payload>
       
   #### applepay process   

       php .\src\examples.php -m  APPLEPAY_PROCESS -p <pay-id-from-previous-applepay-init-call>

   #### googlepay echo
    
       php .\src\examples.php -m GOOGLEPAY_ECHO  

   #### googlepay init

       php .\src\examples.php -m GOOGLEPAY_INIT -i .\config\googlepay-init-base.json -t  <base64 encoded payload>

   #### googlepay process

       php .\src\examples.php -m GOOGLEPAY_PROCESS -p <pay-id-from-previous-googlepay-init-call>