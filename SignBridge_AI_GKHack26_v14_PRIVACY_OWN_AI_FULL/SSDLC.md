# SignBridge AI — Secure System Development Life Cycle (SSDLC)

**Pamsitha Technologies — Geekulcha Annual Hackathon 2026**

## 1. Security Requirements (Risk Assessment)
- Identify personal-information risks before development.
- Minimise collection of account and camera-related data.
- Camera access requires explicit browser permission.
- Do not retain raw camera footage by default.
- Identify POPIA obligations for personal information and any future biometric/AI training data.

## 2. Threat Modelling & Design Review
- Review authentication, sessions, API endpoints and database access.
- Consider unauthorised account access, credential attacks, session abuse, data leakage and malicious input.
- Separate frontend from PHP/MySQL services.
- Keep database credentials server-side and never expose them in frontend JavaScript.

## 3. Development (Secure Coding Practices)
- Passwords are hashed with PHP password hashing functions.
- Use server-side session authentication.
- Validate and sanitise user input.
- Use prepared database statements.
- Avoid hard-coded production secrets.
- Keep camera processing permission-based and minimise retained data.

## 4. Security Testing
- Test registration and login validation.
- Test invalid credentials and expired sessions.
- Test unauthorised access to protected application routes.
- Test API inputs and database operations.
- Test camera permission denial and camera-device errors.
- Test the application in online and offline conditions.

## 5. Assessment & Secure Integration
- Review security controls before pilot deployment.
- Verify PHP/MySQL configuration and access controls.
- Use HTTPS for hosted deployment.
- Review third-party AI/model services and their data-handling requirements.
- Continue security reviews as the SASL model and institutional integrations expand.

### POPIA principle
SignBridge is designed around data minimisation, purpose limitation, access control, appropriate consent, secure processing and responsible handling of personal information. Any future collection of biometric or identifiable training data will require an additional privacy/legal assessment and appropriate consent.
