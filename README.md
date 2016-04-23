## ManagEnv Environment Variable Management System

ManagEnv is a lightweight environment manager built on the Laravel framework. This framework is built for small private groups of 
developers who find the passing around of .env files cumbersome. For larger systems with lots of intricate moving parts, a system 
like Ansible, Chef, or Capistrano might fit you better. 

Our company, like many others, has several environments that have different settings, like database passwords, API keys, and other 
pieces that need to be managed. With one person managing this set up, it's easy, but once there are a bunch of developers trying 
to manage new APIs, and all the while continuously doing builds and deployments, it can get unruly. Checking in these files to 
source control is a big no-no, so we need to do something else.

So ManagEnv is built to help with all that. Environment settings can be managed through the web interface, and exported into a 
.env file for consumption. Exporting is built into a CLI to allow for scripted deployment.

## Installation

Currently: 
Clone the project. 
Create your .env file from the .env.example
   - Point it to a MySQL database. (PRIVATE)
   - Run php artisan migrate to create the tables necessary.
   - Set the APP_KEY: This is how your values get encrypted. Pick a good one.
Point a web server to it.
   
First version, doesn't have all the bells and whistles yet. We're getting there, I promise. 