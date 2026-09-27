# SignBridge AI — Privacy & Security Notes

## Core principle
SignBridge's core recognition should not depend on a general-purpose external LLM. The focused SASL recognition pipeline is intended to use SignBridge's own feature/model layer after hand-landmark extraction.

## Data-flow target
Camera -> browser/device -> hand landmarks -> SignBridge recognition model -> text/speech.

Raw camera footage is not intended to be retained by default.

## Account data
Account/profile information belongs in the application database and should be separated from model-training data. Passwords must be stored only as secure password hashes.

## Training data
Production users are not automatically training data. Any dataset used to train or improve the recognition model should have its own documented collection, consent and governance process.

## External AI
Do not send camera frames, conversations, profile information or other personal information to an external LLM/API unless the user has been explicitly informed and the architecture has been reviewed.

## Important limitation
This is a hackathon prototype. The privacy notice is a product-design commitment, not a legal certification. Before production deployment, verify every actual network request, hosting provider, database location, logs, backups, analytics service and third-party SDK against the privacy notice and POPIA requirements.
