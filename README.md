# 🎮 Twitch Scrolling Status Widget

This project creates a beautiful scrolling list of Twitch streamers showing:
- Their live profile images
- A green or red status dot (green = live, red = offline)
- Their usernames
- A clickable link to each Twitch profile
- Smooth horizontal scrolling that pauses on hover
- Live updates every 10 minutes using the Twitch API

> Perfect for embedding on streamer hubs, community websites, or event pages.

---

## 🔧 Features

- ✅ Auto-scrolling Twitch user bar  
- ✅ Hover-to-pause  
- ✅ Online/offline indicator  
- ✅ Live profile picture updates  
- ✅ Caching to reduce API usage (updates every 5 minutes)  
- ✅ Easy to customize list of Twitch usernames  

---

## 🗂️ Project Structure

/twitch-scroller
├── index.html # Frontend display
├── twitch_data.php # Backend script that fetches Twitch info
├── twitch_cache.json # Auto-generated cache file (do not edit)
├── README.md # You're reading this

---

## 🔌 Requirements

- PHP 7.2+ with `cURL` enabled  
- A Twitch Developer App with:
  - `Client ID`
  - `Client Secret`

---

## ⚙️ Setup Instructions

### 1. Clone this Repo

```bash
git clone https://github.com/MrrZed0/Twitch-Scrolling-Status-Widget.git
cd Twitch-Scrolling-Status-Widget
```

## ⚙️ Get Twitch API Credentials:
1) Go to: https://dev.twitch.tv/console/apps
2) Click "Register Your Application"
3) Set a Redirect URL (can be anything like http://localhost)
4) Copy your Client ID and Client Secret

### 🗂️ Update twitch_data.php
Open twitch_data.php and set your Twitch API credentials:
```
$client_id = 'YOUR_CLIENT_ID_HERE';
$client_secret = 'YOUR_CLIENT_SECRET_HERE';
```

### 🗂️ Update the List of Twitch Users:
In the same file, modify the list of usernames:
```
$usernames = [
    'mrrzed0',
    'sour_diesel01',
    'the_lost_in_the_sauce',
    // Add or remove Twitch usernames here
];
```

### 🧠 How It Works:
- index.html loads the Twitch list dynamically via JavaScript
- twitch_data.php queries the Twitch API and saves results to twitch_cache.json
- Status is updated every 5 minutes
- Hovering stops the scroll animation


### 🛠 Customization:
| Feature       | Where to Edit                                              |
| ------------- | ---------------------------------------------------------- |
| Scroll speed  | `index.html` CSS: `animation: scroll 15s linear infinite;` |
| Status colors | `index.html` JavaScript `.status-dot` div                  |
| User list     | `twitch_data.php` → `$usernames = [...]`                   |
| Cache time    | `twitch_data.php` → `$cache_duration = 300` (in seconds)   |


### 🙌 Credits
- Created by MrrZed0
- Uses the Twitch Helix API


### 📜 License
MIT — free to use, share, and modify.
