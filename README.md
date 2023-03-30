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
npm start

# Start Jekyll to serve everything.
# The -l flag will automatically reload the browser after changes.
jekyll serve -l

# Alternatively, you can run Jekyll in Docker:
docker run --rm -v "$PWD:/srv/jekyll" -p '4000:4000' -it jekyll/jekyll:3 jekyll serve -l

# Run a production build:
npm run prod
```

You can now view the site on: http://localhost:4000

Because the site uses Tailwind,
you also need to run the CSS bundler when changing classes used in the HTML,
as unused classes will be pruned from the generated stylesheet.

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
npm start
```
