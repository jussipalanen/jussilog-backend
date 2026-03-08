# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {YOUR_AUTH_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Authenticate with a Sanctum bearer token via the Authorization header, for example: <code>Authorization: Bearer {token}</code>.
