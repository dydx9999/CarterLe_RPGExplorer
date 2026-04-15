# RPG Explorer

RPG Explorer is a browser-based PHP story game where players log in, choose a class, and progress through branching narrative choices that affect stats, inventory, score, and ending.

## Features

- Session-based login/register flow
- Input validation for usernames and passwords
- Class selection (`warrior`, `mage`, `rogue`) with unique starting stats/items
- Branching story engine with score deltas per choice
- Ending system with multiple outcomes
- Session run history shown on the conclusion page
- Shared responsive UI via one stylesheet (`styles.css`)

## Tech Stack

- PHP (server-side rendering + sessions)
- HTML5 + CSS3
- No database (current authentication/progress is session-only)

## Project Structure

```text
RPGExplorer/
├── index.php                 # Landing page
├── login.php                 # Login form + validation + session start
├── register.php              # Registration form + validation + session start
├── game.php                  # Main story engine, class select, branching choices
├── conclusion.php            # Ending screen + session run history
├── logout.php                # Session teardown and redirect
├── leaderboard.php           # Placeholder leaderboard page
├── common.php                # Shared helpers (layout + requireLogin)
├── styles.css                # Shared styles
├── assets/                   # Story art, avatars, banners, ending gifs
├── favicon_io/               # Favicons and manifest
├── reference/                # Class/reference exercises (sessions, assignment samples)
└── TODO.md                   # Development checklist
```

## Getting Started

### Prerequisites

- PHP 8.0+ installed locally
- Any modern web browser

### Run Locally

1. From the project root, start PHP's built-in server:

```bash
php -S localhost:8000
```

2. Open:

```
http://localhost:8000/index.php
```

### Live URL Access

1. Project can also be accessed through the live CODD server URL:

   ```
   codd.cs.gsu.edu/~cle46/web/pw/pw2/index.php
   ```

## Gameplay Flow

1. Open `index.php`
2. Register or log in
3. Select a hero class
4. Make story choices in `game.php`
5. Reach an ending and review summary/history in `conclusion.php`
6. Start a new run or log out

## Login & Register Validation Rules

- Username: `3-20` chars, letters/numbers/underscore only
- Password: `8-64` chars with at least:
- one uppercase letter
- one lowercase letter
- one number
- one symbol

## Accessing The Leaderboard

- The leaderboard can be viewed at a glance in the primary sidebar of game.php. The leaderboard updates dynamically as users progress through the game.
- Completed run history is stored in `$_SESSION['scores']` and mirrored to a browser cookie (`rpg_scores`) so runs persist across revisits on the same browser.
- If a session expires but `rpg_scores` exists, the app restores access in anonymous mode as `Explorer` with prior run history.

## Team Members

- Carter Le
  - ID: 002651184
  - PHP Contribution: All project PHP contributions

## Session Model

- `$_SESSION['user_id']`: active user id
- `$_SESSION['username']`: active username
- `$_SESSION['hero']`: selected class, stats, items, score
- `$_SESSION['node']`: current story node
- `$_SESSION['ending_node']`: final node reached

## Known Limitations

- No persistent server-side user accounts or database-backed save system
