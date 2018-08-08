# #ThrowTogetherThursdays  [![Build Status](https://travis-ci.org/matt-bartlett/t3.svg?branch=master)](https://travis-ci.org/matt-bartlett/t3)
Public API storing all Spotify playlists from T3. Can be used as a generic Spotify playlist store.

## Docs
The API consists of 3 endpoints:

Fetch all Playlists, paginated by 24 results.
```
http://<domain>/api/playlists
```

Fetch a Playlist by ID, with associated Tracks.
```
http://<domain>/api/playlists/<ID>
```

Search for Tracks, Artists or Albums.
```
http://<domain>/api/search?q=<SEARCHTERM>
```
