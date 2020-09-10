## Genome payment module for OXID 6.2 or higher.

### INSTALLATION:
Module is installed via composer or manually. During manual installation do not 
forget to run composer install/update to include module path to autoload. 


### GENERAL SETUP:
1. Login/register to https://merchant.genome.eu/  
2. Create Payment page and get Public/Private keys (test keys are also available here).  
3. Use these keys to configure Genome payment module.  
4. On module configuration page you can enable Sandbox mode if neccessary.  
5. All the other settings are done in Genome control panel (https://merchant.genome.eu/).  
There you can specify success/decline/callback urls for test/prod mode.  

### Recommendations are:

Success url: {{YOUR_SITE_URL}}/index.php?cl=thankyou  
Decline url: {{YOUR_SITE_URL}}/index.php?cl=thankyou  
Callback url: {{YOUR_SITE_URL}}/index.php?cl=genomeorder&fnc=postback  

{{YOUR_SITE_URL}} - your site url (e.g. https://genome.eu/)

### USAGE
Payment processing is done by redirecting the Customer to Genome payment page.   
All the payment settings are done in Genome Control Panel (https://merchant.genome.eu/).  

### REFUND FUNCTIONALITY
To refund an order you need select an Order, go to Genome tab and click Refund order.
This will allow full order refund to be done.