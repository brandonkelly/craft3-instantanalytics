# Instant Analytics plugin for Craft CMS 3.x

Instant Analytics brings full Google Analytics support to your Twig templates

**Note**: This plugin may become a paid add-on when the Craft Plugin store becomes available.

Related: [Instant Analytics for Craft 2.x](https://github.com/nystudio107/instantanalytics)

![Screenshot](screenshots/plugin-logo.png)

**N.B.:** Support for Craft Commerce is _not_ in this version. It is pending the release of Commerce 2 beta for Craft 3

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft3-instantanalytics

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Instant Analytics.

## Instant Analytics Overview

Instant Analytics brings full Google Analytics support to your Twig templates and automatic Craft Commerce integration with Google Enhanced Ecommerce.

Instant Analytics also lets you track otherwise untrackable assets & events with Google Analytics, and eliminates the need for Javascript tracking.

You don't need to include the typical Google Analytics script tag on your pages, instead Instant Analytics will send page views when your front-end templates are rendered via the officially supported [Google Measurement Protocol](https://developers.google.com/analytics/devguides/collection/protocol/v1/).

You can also track asset/media views in Google Analytics, either as PageViews or as Events. This lets you track otherwise untrackable things such as individual RSS feed accesses, images, PDF files, etc.

If you are using Craft Commerce, Instant Analytics will automatically send Google Analytics Enhanced eCommerce data to your Google Analytics account as items are added/removed from your cart, and orders are tracked as well.

Instant Analytics is implemented on the demo site [Brads for Men](https://bradsformen.com)

## Use Cases

### Simple Page Tracking

If all you want is simple page tracking data sent to Google Analytics, Instant Analytics will do that for you automatically.  Instant Analytics uses the [Google Measurement Protocol](https://developers.google.com/analytics/devguides/collection/protocol/v1/) to send PageViews to your Google Analytics account the same way the Google Analytics Tracking Code Javascript tag does.

In addition, Instant Analytics injects an `instantAnalytics` object into your templates, which you can manipulate as you see fit, adding Google Analytics properties to be sent along with your PageView.

It has the added benefit of not having to load any Javascript on the front-end to do this, which results in the following benefits:

* Your pages will render quicker in-browser, with no external resources loaded just for PageView tracking
* Pages will be tracked even if the client's browser has Javascript disabled or blocked
* Javascript errors will not cause Google Analytics data to fail to be collected

### Craft Commerce Integration with Google Enhanced Ecommerce

If you are using Craft Commerce, Instant Analytics will recognize this, and automatically send Google Enhanced Ecommerce data for the following actions:

* **Add to Cart** - When someone adds an item from your Craft Commerce store to their cart.  This will include data for the Product or Variant that was added to the cart.
* **Remove from Cart** - When someone removes an item from your Craft Commerce store cart (requires Craft Commerce 1.2.x or later).  This will include data for the Product or Variant that was removed from the cart.
* **Purchase** - When someone completes a purchase in your Craft Commerce store.  This will include all of the LineItems that were added to the cart, as well as the TransactionID, Revenue, Tax, Shipping, and Coupon Code used (if any).

Additionally, you can add simple Twig tags to your templates to track Product Impressions, Product Detail Views, and track each step of the Checkout process.  In Google Analytics, you will be able to view detailed information on the sales from your Craft Commerce store, and other useful information such as where customers are abandoning their cart in the Checkout process.

### Tracking Assets/Resources

Instant Analytics lets you track assets/resources that you can't normally track.  For instance, you may have a collection of PDF documents that you'd like to know when they are viewed.

Using a simple `{{ pageViewTrackingUrl(myAsset.url, myAsset.title) }}` or `{{ eventTrackingUrl(myAsset.url, myAsset.title, "action", "label", "value") }}` Twig function, Instant Analytics will generate a public URL that will register a PageView in Google Analytics for the asset/resource, and then display or download the asset/resource.

### Tracking RSS Feeds

Getting actual tracking statistics on RSS feeds can be notoriously difficult, because they are often consumed by clients that are not web browsers, and therefor will not run Javascript tracking code.

With Instant Analytics, if your RSS feed is a Twig template, accesses will automatically be tracked.  Additionally, you can use the `{{ pageViewTrackingUrl(myAsset.url, myAsset.title) }}` or `{{ eventTrackingUrl(myAsset.url, myAsset.title, "action", "label", "value") }}` Twig functions to track individual episode accesses in Google Analytics.

### Custom Tracking via Twig or Plugin

If your needs are more specialized, Instant Analytics will give your Twig templates or plugin full access to an `Analytics` object that allows you to send arbitrary Google Analytics tracking data to Google Analytics.

You can do anything from customized PageViews to complicated Google Enhanced eCommerce tracking, 

## Configuring Instant Analytics

Once you have installed Instant Analytics, you'll see a welcome screen.  Click on **Get Started** to configure Instant Analytics:

* **Google Analytics Tracking ID:** Enter your Google Analytics Tracking ID here. Only enter the ID, e.g.: UA-XXXXXX-XX, not the entire script code.
* **Auto Send PageViews:** If this setting is on, a PageView will automatically be sent to Google after a every page is rendered. If it is off, you'll need to send it manually using `{% hook 'iaSendPageView' %}`
* **Strip Query String from PageView URLs:** If this setting is on, the query string will be stripped from PageView URLs before being sent to Google Analytics.  e.g.: `/some/path?token=1235312` would be sent as just `/some/path`
* **Auto Send "Add To Cart" Events:** If this setting is on, Google Analytics Enhanced Ecommerce events are automatically sent when an item is added to your Craft Commerce cart.
* **Auto Send "Remove From Cart" Events:** If this setting is on, Google Analytics Enhanced Ecommerce events are automatically sent when an item is removed from your Craft Commerce cart.
* **Auto Send "Purchase Complete" Events:** If this setting is on, Google Analytics Enhanced Ecommerce events are automatically sent a purchase is completed.
* **Commerce Product Category Field:** Choose the field in your Product or Variant field layout that should be used for the product's Category field for Google Analytics Enhanced Ecommerce
* **Commerce Product Brand Field** Choose the field in your Product or Variant field layout that should be used for the product's Brand field for Google Analytics Enhanced Ecommerce

If you have the [SEOmatic](https://github.com/nystudio107/seomatic) plugin installed, Instant Analytics will automatically grab your **Google Analytics Tracking ID:** from it.

**NOTE:** Instant Analytics will work with the traditional Google Analytics Tracking Code Javascript tag; it's not an either/or, they can coexist.  Instant Analytics is just a different way to send the same data to Google Analytics.

However, to prevent duplicate data from being sent, if you use Instant Analytics to send PageView data, you should turn off the Javascript sending PageViews automatically by:

* In [SEOmatic](https://github.com/nystudio107/seomatic) turn off **Automatically send Google Analytics PageView**
* If you don't use SEOmatic, remove the line `ga('send', 'pageview');` from your Google Analytics Tracking Code Javascript tag

Then you can still use the `ga()` calls to send events to Google Analytics.  Or, if you don't send events via Javascript, you can just remove the Google Analytics tag/Javascript from your page entirely.

### Customizing via the config.php file

Instant Analytics has a number of other configuration options that can be customized on a per-environment basis via the `config.php` file.  Don't edit this file, instead copy it to `craft/config` as `instantanalytics.php` (rename it) and make your changes there.

## Using Instant Analytics

### Simple Page Tracking

Once you've entered your **Google Analytics Tracking ID**, Instant Analytics will automatically send PageViews to Google Analytics if you have **Auto Send PageViews** on (which it defaults to). There is no step 2.
  
 If you need to control which pages Instant Analytics sends PageViews on, set **Auto Send PageViews** to `off`.  Then you just need to add a call to `{% hook 'iaSendPageView' %}` to your front-end templates to send PageView tracking to Google Analytics.  We recommend that you do this in a block at the bottom of your `layout.twig` template that other templates extend, right before the `</body>` tag, like this:

    {% block analytics %}
        {% hook 'iaSendPageView' %}
    {% endblock %}

That's it!  Once you have added this hook, Instant Analytics will start sending PageViews to Google Analytics. It does not send any Google Analytics data if:

* You have not entered a valid **Google Analytics Tracking ID:**
* You are viewing templates in Live Preview
* The request is a CP or Console request
* If you have `sendAnalyticsData` set to false in the `config.php` file

By default, the "title" used for your pages is the current template path; if you have [SEOmatic](https://github.com/nystudio107/seomatic) installed, Instant Analytics will automatically grab the current page title from it.

Instant Analytics will also automatically parse and set any [UTM query string parameters](https://blog.kissmetrics.com/how-to-use-utm-parameters/) such as `utm_campaign`, `utm_source`, `utm_medium`, and `utm_content` in the analytics object.

#### Advanced Page Tracking

This is where the fun begins.  Instant Analytics injects an `instantAnalytics` object into your templates, the same way that Craft injects an `entry` object or Craft Commerce injects a `product` object.  This is the actual `Analytics` object that the `{% hook 'iaSendPageView' %}` will send to Google Analytics.

You can manipulate this object as you see fit, adding data to be sent to Google Analytics along with your PageView.

For example, let's say that you want to add an `Affiliation`:

    {% do instantAnalytics.setAffiliation("Brads for Men") %}

Or perhaps for a particular page, you want to change the the `Tracking ID` used by Google Analytics:

    {% do instantAnalytics.setTrackingId("UA-26293624-12") %}

Or do them both at the same time:

    {% do instantAnalytics.setAffiliation("Brads for Men").setTrackingId("UA-26293624-12") %}

You can add or change any property defined in the [Google Analytics Measurement Protocol library for PHP](https://github.com/theiconic/php-ga-measurement-protocol) that Instant Analytics uses.

By default, the injected `instantAnalytics` object is filled in with the following info:

* `instantAnalytics.setProtocolVersion('1')`
* `instantAnalytics.setTrackingId(YOUR_TRACKING_ID)`
* `instantAnalytics.setIpOverride($_SERVER['REMOTE_ADDR'])`
* `instantAnalytics.setUserAgentOverride($_SERVER['HTTP_USER_AGENT'])`
* `instantAnalytics.setDocumentReferrer($_SERVER['HTTP_REFERER'])`
* `instantAnalytics.setClientId(CID)`
* `instantAnalytics.setDocumentPath(craft.request.url)`
* `instantAnalytics.setDocumentTitle(TEMPLATE_PATH)`

If the SEOmatic plugin is installed, then it is used to set the title:

* `instantAnalytics.setDocumentTitle(seomaticMeta.seoTitle)`

If there is a `gclid` cookie (used for Google AdWords tracking), this will also be set:

* `instantAnalytics.setGoogleAdwordsId(GCLID)`

### Craft Commerce Tracking with Google Enhanced Ecommerce

Unimplemented; waiting on Craft Commerce 2.0 for Craft 3 to be released.

### Sending Events

You can obtain an `Analytics` object preloaded to send events to Google Analytics via either:

    {% set myAnalytics = eventAnalytics(CATEGORY, ACTION, LABEL, VALUE) %}
    -OR-
    {% set myAnalytics = craft.instantAnalytics.eventAnalytics(CATEGORY, ACTION, LABEL, VALUE) %}

What `CATEGORY`, `ACTION`, `LABEL`, and `VALUE` are is completely up to you; you can provide whatever data makes sense for your application, and view it in Google Analytics.  See [Event Tracking](https://developers.google.com/analytics/devguides/collection/analyticsjs/events) for more information.

By default, the injected `instantAnalytics` object is filled in with the following info:

* `myAnalytics.setProtocolVersion('1')`
* `myAnalytics.setTrackingId(YOUR_TRACKING_ID)`
* `myAnalytics.setIpOverride($_SERVER['REMOTE_ADDR'])`
* `myAnalytics.setUserAgentOverride($_SERVER['HTTP_USER_AGENT'])`
* `myAnalytics.setDocumentHostName($_SERVER['SERVER_NAME'])`
* `myAnalytics.setDocumentReferrer($_SERVER['HTTP_REFERER'])`
* `myAnalytics.setClientId(CID)`
* `myAnalytics.setEventCategory(CATEGORY)`
* `myAnalytics.setEventAction(ACTION)`
* `myAnalytics.setEventLabel(LABEL)`
* `myAnalytics.setEventValue(VALUE)`

If there is a `gclid` cookie (used for Google AdWords tracking), this will also be set:

* `myAnalytics.setGoogleAdwordsId(GCLID)`

You manipulate the `myAnalytics` object as you see fit, adding or changing any property defined in the [Google Analytics Measurement Protocol library for PHP](https://github.com/theiconic/php-ga-measurement-protocol) that Instant Analytics uses.

However, the event **will not be sent** to Google Analytics until you tell it to via:

    {% do myAnalytics.sendEvent() %}

A complete example might be:

    {% set myAnalytics = eventAnalytics('UX', 'View Ad', entry.someAdName, entry.someImpressions) %}
    {% do myAnalytics.setAffiliation(entry.someAffiliation).sendEvent() %}

### Tracking Assets/Resources

Instant Analytics lets you track assets/resources that you can't normally track, by providing a tracking URL that you use in your front-end templates.

You can track as PageViews via either:

    {{ pageViewTrackingUrl(URL, TITLE) }}
    -OR-
    {{ craft.instantAnalytics.pageViewTrackingUrl(URL, TITLE) }}

Or you can track as Events via either:

    {{ eventTrackingUrl(URL, CATEGORY, ACTION, LABEL, VALUE) }}
    -OR-
    {{ craft.instantAnalytics.eventTrackingUrl(URL, CATEGORY, ACTION, LABEL, VALUE) }}

These can be wrapped around any URL, so you could wrap your tracking URL around an image, a PDF, or an externally linked file... whatever.

What happens when the link is clicked on is Instant Analytics sends the tracking PageView or Event to Google Analytics, and then the original URL is seamlessly accessed.

The URL that Instant Analytics generates will look like this:

    http://yoursite.com/instantAnalytics/pageViewTrack/FILENAME.EXT?url=XXX&title=AAA
    -OR-
    http://yoursite.com/instantAnalytics/eventTrack/FILENAME.EXT?url=XXX&eventCategory=AAA&eventAction=BBB&eventLabel=CCC&eventValue=DDD

It's done this way so that the URL can be directly used in RSS feeds for the media object URLs, which require that the filename is in the URL path.

### Custom Tracking via Twig or Plugin

If your needs are more specialized, you can build arbitrary Google Analytics data packets with Instant Analytics.  To get an `Analytics` object do the following:

Twig:

    {% set myAnalytics = craft.instantAnalytics.analytics() %}

PHP via Plugin:

    $myAnalytics = InstantAnalytics::$plugin->ia->analytics();

In either case, you will be returned an `Analytics` object that is initialized with the following settings for you:

    $myAnalytics->setProtocolVersion('1')
        ->setTrackingId(YOUR_TRACKING_ID)
        ->setIpOverride($_SERVER['REMOTE_ADDR'])
        ->setAsyncRequest(false)
        ->setClientId(CID);
        ->setGoogleAdwordsId(GCLID);

You are then free to change any of the parameters as you see fit via the [Google Analytics Measurement Protocol library for PHP](https://github.com/theiconic/php-ga-measurement-protocol)

Here's a simple example where we send a PageView for a specific page (after adding an Affiliation):

Twig:

    {% set myAnalytics = craft.instantAnalytics.analytics() %}
    {% do myAnalytics.setDocumentPath('/some/page').setAffiliation('nystudio107').sendPageview() %}

PHP via Plugin:

    $myAnalytics = InstantAnalytics::$plugin->ia->analytics();
    $myAnalytics->setDocumentPath('/some/page')
        ->setAffiliation('nystudio107')
        ->sendPageview();

The sky's the limit in either case, you can do anything from simple PageViews to complicated Google Enhanced eCommerce analytics tracking.

## Instant Analytics Roadmap

Some things to do, and ideas for potential features:

* Add Craft Commerce support when Commerce 2 beta for Craft 3 becomes available

Brought to you by [nystudio107](http://nystudio107.com)