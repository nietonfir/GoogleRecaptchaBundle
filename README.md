GoogleReCaptchaBundle
=====================

[ReCAPTCHA](https://developers.google.com/recaptcha/) is a free CAPTCHA service that protects websites from spam and abuse.
This bundle uses the [GoogleReCaptcha](https://github.com/nietonfir/GoogleReCaptcha) library or validating a users "No CAPTCHA reCAPTCHA" response and provides a custom form type, a custom validation constraint as well as a validator to use with the [Symfony Form Component](https://github.com/symfony/Form).

Installation
------------

The recommended way to install GoogleReCaptchaBundle is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of GoogleReCaptcha:

```bash
composer require "nietonfir/google-recaptcha-bundle"
```

Or add GoogleReCaptchaBundle in your `composer.json`

```js
"require": {
    "nietonfir/google-recaptcha-bundle": "dev-master"
}
```

and tell Composer to install the library:

``` bash
composer update "nietonfir/google-recaptcha-bundle"
```

After installing, don't forget to enable the bundle:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Nietonfir\Google\ReCaptchaBundle\NietonfirGoogleReCaptchaBundle(),
    );
}
```

Configuration
-------------

Add the following configuration to your `config.yml`.
```yaml
nietonfir_google_recaptcha:
    sitekey: <your_site_key_here>
    secret: <and_your_secret_here>
    validation:
        form_name: <your_form_name>
        field_name: recaptcha
```

Additionally you have to add the corresponding form field themes depending on
your used templating engine in `config.yml`.

```yaml
# Twig
twig:
    debug:            "%kernel.debug%"
    strict_variables: "%kernel.debug%"
    form_themes:
        - 'NietonfirGoogleReCaptchaBundle:Form:fields.html.twig'

# PHP
framework:
    templating:
        form:
            resources:
                - 'NietonfirGoogleReCaptchaBundle:Form'
```

Usage
-----

Using the Bundle is dead simple:
1. Create your form type as usual
2. Add a field using the `recaptcha` field type
    
    ```
    $builder->add('recaptcha', 'recaptcha');
    ```
    
3. Make your controller implement `ReCaptchaValidationInterface`
    
    ```
    use Nietonfir\Google\ReCaptchaBundle\Controller\ReCaptchaValidationInterface;

    class DefaultController extends Controller implements ReCaptchaValidationInterface
    ```
    
4. …
5. Profit!

Now when `form->isValid()` is called, the submitted reCAPTCHA response is validated against the Google API.
Be advised that both the form and the field name used have to be set in `config.yml`.

TODOs
-----
* Add some `info()` to the form & field name config values in `Configuration.php`
* Translate the error messages returned form the Google API to something more meaningful
* Update documentation
* Add some more examples
* Add missing unit tests

