[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Lendable/VisitorTrackingBundle/badges/quality-score.png)](https://scrutinizer-ci.com/g/Lendable/VisitorTrackingBundle/?branch=master)
[![Build Status](https://api.travis-ci.org/Lendable/VisitorTrackingBundle.svg?branch=master)](https://www.travis-ci.org/Lendable/VisitorTrackingBundle)
[![Coverage Status](https://coveralls.io/repos/github/Lendable/VisitorTrackingBundle/badge.svg?branch=master)](https://coveralls.io/github/Lendable/VisitorTrackingBundle?branch=master)
[![Latest Stable Version](https://poser.pugx.org/lendable/visitor-tracking-bundle/version)](https://packagist.org/packages/lendable/visitor-tracking-bundle)
[![Total Downloads](https://poser.pugx.org/lendable/visitor-tracking-bundle/downloads)](https://packagist.org/packages/lendable/visitor-tracking-bundle)

Visitor Tracking Bundle
=======================

A Symfony bundle to track requests.
1. Installation
```
composer require kematjaya/visitor-tracking-bundle
```
2. Update Database
```
php bin/console doctrine:schema:update --force
```

3. Import Routing
```
## config/routes/annotations.yaml
visitor:
    resource: "@VisitorTrackingBundle/Resources/config/routing.yml"
```
4. Add Js to base.html.twig 
```
{{ device_js() }}
```

troubleshoot in postgresql
- CREATE EXTENSION IF NOT EXISTS "uuid-ossp";