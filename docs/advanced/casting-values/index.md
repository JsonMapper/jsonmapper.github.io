---
permalink: /docs/advanced/casting-values
title: Casting values  
---

JsonMapper out of the box wil come with a ScalarCaster configured to cast values to the following types:
 `boolean`, `integer`, `string`, `float` and `mixed`. These casts are applied in order to match the 
properties of the class your trying to map to.

Alternatively you can configure your mapper using the JsonMapperBuilder to configure the StrictScalarCaster.
This caster will throw an `Exception` when the type of the JSON value doesn't match the type the property of
the class your trying to map to.