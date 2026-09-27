# SignBridge AI — Teachable Machine Guide

SignBridge can optionally load a custom Google Teachable Machine image model.

## Why
The current MediaPipe detector is a hand-landmark foundation. It is not a trained SASL recognizer. A Teachable Machine model lets us train a small, controlled vocabulary using real examples.

## Train
1. Open https://teachablemachine.withgoogle.com/
2. Choose **Image Project**.
3. Create classes such as:
   - Hello
   - Thank you
   - Please
   - Help
   - Yes
   - No
   - I need help
   - Nothing / No hand
4. Capture many examples for each class from multiple angles, distances and lighting conditions.
5. Train the model and test it with images it has not seen.
6. Export the model and choose the hosted model option.
7. Copy the model URL.
8. In SignBridge → Train AI → Teachable Machine, paste the URL and click **Load Teachable Machine model**.

## Important
These class names must only be presented as SASL signs after they have been verified with SASL users/educators and the training data is appropriately consented and licensed. Do not claim an accuracy percentage unless it has been measured on a held-out test set.

The Google tool supports image projects from webcam/files and exports TensorFlow.js models that can run in JavaScript applications.
