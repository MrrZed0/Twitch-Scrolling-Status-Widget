# 🎮 Twitch Scrolling Status Widget

This project creates a beautiful scrolling list of Twitch streamers showing:
- Their live profile images
- A green or red status dot (green = live, red = offline)
- Their usernames
- A clickable link to each Twitch profile
- Smooth horizontal scrolling that pauses on hover
- Live updates every 5 minutes using the Twitch API

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

## 🚀 Demo Screenshot

![demo](https://your-screenshot-url-if-any.png)

---

## 🗂️ Project Structure


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
git clone https://github.com/MrrZed0/twitch-scroller.git
cd twitch-scroller

## ⚙️ Get Twitch API Credentials
- Go to: https://dev.twitch.tv/console/apps
- Click "Register Your Application"
- Set a Redirect URL (can be anything like http://localhost)
- Copy your Client ID and Client Secret
```bash
$client_id = 'YOUR_CLIENT_ID_HERE';
$client_secret = 'YOUR_CLIENT_SECRET_HERE';
