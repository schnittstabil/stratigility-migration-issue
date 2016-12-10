# Stratigility Migration Issue [![Build Status](https://travis-ci.org/schnittstabil/stratigility-migration-issue.svg?branch=master)](https://travis-ci.org/schnittstabil/stratigility-migration-issue)

> :boom: Against [PSR-15 Hacks](https://github.com/http-interop/http-middleware/issues/44) :boom:

This is a demo which shows one of many drawbacks of `ServerMiddlewareInterface::process`.

1. In version `1.0.0` everything is green: [Travis Build #2](https://travis-ci.org/schnittstabil/stratigility-migration-issue/builds/182820532)

2. We add the new PSR-15 functionality:

```diff
-class ContentNegotiationMiddleware implements MiddlewareInterface
+class ContentNegotiationMiddleware implements MiddlewareInterface, ServerMiddlewareInterface
 {
+    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
+    {
+        $accept = $request->getHeaderLine('Accept');
+        $type = $this->negotiate($accept);
+        $request = $request->withHeader('Accept', $type);
+
+        return $delegate->process($request);
+    }
```

## License

MIT © [Michael Mayer](http://schnittstabil.de)
