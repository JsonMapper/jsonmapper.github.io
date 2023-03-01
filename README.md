# JsonMapper.net

This repository contains the source code for the [JsonMapper.net](https://jsonmapper.net) website.
For the JsonMapper package, see the [JsonMapper/JsonMapper](https://github.com/JsonMapper/JsonMapper) repository.

## Local Development

Requirements:

- [Node.js](https://nodejs.org/)
- [Jekyll](https://jekyllrb.com/)

Jekyll is used to generate the pages,
and webpack is used to bundle the styles.

To get the site up and running locally, run:

```shell
# Install all packages.
npm i

# Bundle the CSS in watch mode.
npm run watch
# Alternatively, to bundle the CSS without watching.
npm run prod

# Start Jekyll to serve everything.
jekyll serve
```

You can now view the site on: http://localhost:4000

### Troubleshooting

Note that if you use Node.js v17 or higher you will get an `ERR_OSSL_EVP_UNSUPPORTED` error like:

```
node:internal/crypto/hash:71
  this[kHandle] = new _Hash(algorithm, xofLen);
                  ^

Error: error:0308010C:digital envelope routines::unsupported
[...]
```

To fix this, you can either use Node.js v16,
or tell Node.js to use the legacy OpenSSL provider:

```shell
export NODE_OPTIONS=--openssl-legacy-provider
npm run watch
```
