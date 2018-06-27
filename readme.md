# ThrowTogetherThursdays
Public API storing all Spotify playlists from T3. May later add a backend for managing playlists you no longer want clogging up your Spotify.

# Docs
The API consists of 3 end-points.

Fetch all Playlists, paginated at 24 results.

```php
http://<domain>/api/playlists
```

Fetch a Playlist, with associated Tracks
```php
http://<domain>/api/playlists/$id
```

Search for Tracks, Artists or Albums
```php
http://<domain>/api/search?q=<searchterm>
```
