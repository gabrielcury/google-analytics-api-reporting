#Simple Google Analytics API Reporter

Written in the [Silex](http://silex.sensiolabs.org/) micro PHP framework, this simple app lets your get visits for a Google Analytics view using the Analytics API.  It uses a regular cron task on a web server to send the reported values to an email of your choosing.

##Installation

###Dependencies
Clone the repository and install [composer.phar](http://getcomposer.org/download/) in the app directory:

```
curl -sS https://getcomposer.org/installer | php
```

Run the following in a terminal to install Silex and the Google Analytics API.  This looks at the composer.json file included:

```
php composer.phar update
```

###Analytics API Setup
Set up the Google Analytics API.  Go to the [Google API Console](https://code.google.com/apis/console/) and create a new app.

In the Services tab, flip the Google Analytics switch.

In the API Access tab, click Create an OAuth2.0 Client ID.

*Enter your name, upload a logo, and click Next
*Select the Service account option and press Create client ID
*Download your private key.  This only pops up if you've selected a Service account.

Now you're back on the API Access page. You'll see a section called Service account with a Client ID and Email address

*Copy the email address (something like ####@developer.gserviceaccount.com)
*Visit your [Google Analytics](https://www.google.com/analytics/web/#management/Accounts/) Admin and add this email as a user to your properties
*This is a must; you'll get cryptic errors otherwise.

###App Configuration

Put your .p12 key in the root /app directory.

In your Google Analytics admin, find the view ID of the view you want visitor stats from.

Fill out the configuration values in app/web/index.php based on your settings.

Set your web root to app/web.

You should be able to send off reports with visitor counts by visiting http://www.yourapp.com/doreports?username=USERNAME&password=PASSWORD

Set up a cron task to execute at regular intervals for relevant information like so:

```
wget "http://www.yourapp.com/doreports?username=USERNAME&password=PASSWORD" -o /dev/null
```

##Notes
You can edit this to use anything from the Analytics API, not just visits.  It's a good base for other reporting and you can set your cron task to send an email weekly, monthly, etc.