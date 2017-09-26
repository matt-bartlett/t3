# ThrowTogetherThursdays
Public API storing all Spotify playlistsfrom T3. May later add a backend for managing playlists you no longer want clogging up your Spotify.

### Docs
The API consists of 2 end-points.

Fetch all Playlists, paginated at 15 results.

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

### Things To Do (Nice to haves)
- [ ] - Add Tests for Track/Artist/Album search endpoint
- [ ] - Add an auth-guarded section for easily pulling playlists from Spotify
- [ ] - Add an auth-guarded section of allowed Spotify users to have their playlists shown
