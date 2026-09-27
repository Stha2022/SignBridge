# SignBridge AI — GKHack26 Mobile Build

## What changed
- Mobile-first UI inspired by the supplied purple/white app reference.
- Welcome, Create Account and Login screens.
- Local-first account/profile flow so the demo can work offline.
- Personalised greeting, preferred language and saved emergency phrases.
- Installable PWA with manifest, service worker and Android/Chrome install prompt.
- Mobile hamburger navigation / desktop sidebar.
- Camera now opens **before** AI model loading so a model-loading problem cannot block camera access.
- MediaPipe Hands remains the on-device vision layer; first launch should be online once so the model assets can be cached.
- Removed long privacy/disclaimer blocks from the main user flow.
- Added PHP/MySQL authentication files for the user's preferred deployment stack (`api/`).

## Run locally
```bash
npm.cmd install
npm.cmd start
```
Open `http://localhost:3000`.

## Camera
Use localhost or HTTPS. When Chrome asks for camera permission, choose **Allow**.
The camera should start even if the AI model is still loading.

## PWA / downloadable app
Use Chrome on Android/desktop and select **Install SignBridge** when the Install button appears.
On iPhone: Safari → Share → Add to Home Screen.
For a fully native Android APK later, use the included Capacitor configuration.

## Offline behaviour
The app shell, profile, local account, favourites and trained samples are stored locally. MediaPipe runtime assets are cached after the first successful online load. A fully zero-internet first-run requires bundling the MediaPipe assets into the application package.

## PHP + MySQL
The `api/` folder contains:
- `schema.sql` — MySQL database/tables
- `config.php.example` — XAMPP credentials template
- `auth.php` — registration/login API using PHP password hashing

For the hackathon demo, the browser local-first account flow keeps the app usable offline. The PHP/MySQL layer is the path for online account persistence/sync when deployed under XAMPP/Apache.

## Suggested demo journey
Welcome → Create account → choose language → personalised home → Start camera → show gesture → recognised output → Speak → Emergency → Install/offline.


## Custom sign recognition
The Sign → Text screen now supports an optional Teachable Machine TensorFlow.js image model. Train a controlled vocabulary in Teachable Machine, export/host it, then load its model URL from Train AI. Without a custom model, SignBridge falls back to MediaPipe hand landmarks and local landmark samples.

## v10 streamlined navigation
The end-user navigation is intentionally limited to Sign -> Text and Text -> Sign. Training tools are retained in the codebase for the next development phase but are not exposed as a separate page. Emergency communication is embedded into the Sign -> Text screen instead of using a separate page. Profile is removed as a separate page; language remains available in the top bar and is persisted through the PHP API.

## Focused SASL training in the camera screen

The current prototype includes a guided six-sign training vocabulary:
- Hello
- Thank you
- Please
- Help
- Yes
- No

Users can start the camera, select a target sign and collect local landmark samples. The interface recommends at least 30 varied samples per sign. These samples remain on the device in the prototype. A Teachable Machine model can also be loaded as the primary recogniser.

This does **not** mean the prototype already has validated SASL accuracy. Production recognition requires consented, community-validated SASL data, representative examples and formal evaluation.

## Learning resources

The camera screen includes links to selected SASL learning resources, including NID resources and SASL tutorial videos. External resources remain clearly attributed to their publishers.
