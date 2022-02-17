EvotodiWaveBundle
===================

The EvotodiWaveBundle adds support for WaveApps.com graphQL api.

This is a port of [subbe/waveapp](https://github.com/subbe/waveapp) to symfony.
There are probably bugs in this version, please report them.


Documentation
-------------

Slim to none. See the source code.

Installation
------------

```composer require evotodi/wave-bundle```

Add the following environment variables
```
WAVEAPPS_ACCESS_TOKEN=[YOUR TOKEN HERE]
WAVEAPPS_GRAPHQL_URI=https://gql.waveapps.com/graphql/public
WAVEAPPS_BUSINESS_ID=[YOUR DEFAULT BUSINESS ID HERE]
```

License
-------

This bundle is under the MIT license. See the complete license [in the bundle](LICENSE)


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/evotodi/waveapp/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.
