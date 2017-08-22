
# Social Combo

http://websocial.theshiftleft.com

Social Combo is a simpler and easier way to monitor how well each post goes on many social media sites.

### Controllers
- App - Houses the entire application logic
- Login - Manages login processes and front end for logging in
- Register - Manages registration logic for the app (Standard in-app registration)
- Social - Processor for all registrations and api callbacks
- Welcome - Default controller for front end static pages

### Libraries (Extends the code from third_party providers from social media SDKs)
- Facebook CI -  Login url generation, callback and profile acquisition
- Twitter CI - Url redirection, callback and credential verification
- LinkedIn CI  - Login url generation, callback and profile acquisition

### Models (Handles CRUD operations)
- Social Account model - Social Accounts base model
- UserAccount - User base model

### Views
- default_view - The primary front end of the application
- comingsoon_view - Static coming soon page
- home_page - Future static welcome page
- login_view - Login front end ui
- register_view - Registration front end ui
- template_only - As the name implies template only file
- welcome_message - Codeigniter's default view (i'm keeping this one)