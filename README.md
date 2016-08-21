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

## Requirements

* PHP >=5.5 Installed
* A SQL Installation. The flavor shouldn't matter much, but I know MySQL is currently working.
* A Web Server such as Apache or Nginx if you want to use the Web Component

## Installation

Currently: 

* Clone the project. 
* Create your .env file from the .env.example
    * Point it to a SQL database. (PRIVATE)
    * Run php artisan key:generate to create a secure APP_KEY
    * Run php artisan migrate to create the tables necessary.
    * Point a web server to it.
   
This is the first version, and doesn't have all the bells and whistles yet. We're getting there, I promise.

## Usage
The project has both a Web Interface and a CLI component, and can be used both independently or with a small group.
It should be hosted on a Private Server for only your collegues to access: Currently it is trivially easy to sign up for
an account and view all environment values. This will be changed in an upcoming version.

The web interface is pretty barebones. You can create a new environment, which may inherit values from a parent. Adding and editing
values is as simple as typing in the textboxes.

Environment variable names are always converted to all caps. This is usually standard for .env files. You can download a .env file by
clicking the save button in the corner of any environment.

The CLI currently allows Exporting, Importing, Creating Environments, Setting and Getting Variables:

    php artisan env:export {environment name} {file location}
    php artisan env:import {file location} --name={optional environment name} --parent={optional parent environment name}
    php artisan env:create {name} --parent={optional parent environment name}
    php artisan env:set {environment name} {variable name} {value}
    php artisan env:get {environment name} {variable name}

## Planned Features
* Generate .env.example files from both interfaces
* Color/Symbol Coding of environment levels for easily visible inheritance
* Updating security to allow the possibility of a semi-public server
* BASH scripts to simplify the CLI calls
* Installation script to simplify installation
