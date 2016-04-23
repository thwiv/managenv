@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <h2>ManagEnv Environment Variable Management System</h2>
                    <p>
                    ManagEnv is a lightweight environment manager built on the Laravel framework. This framework is built for small private groups of
                    developers who find the passing around of .env files cumbersome. For larger systems with lots of intricate moving parts, a system
                    like Ansible, Chef, or Capistrano might fit you better.
                    </p>
                    <p>
                    Our company, like many others, has several environments that have different settings, like database passwords, API keys, and other
                    pieces that need to be managed. With one person managing this set up, it's easy, but once there are a bunch of developers trying
                    to manage new APIs, and all the while continuously doing builds and deployments, it can get unruly. Checking in these files to
                    source control is a big no-no, so we need to do something else.
                    </p>
                    <p>
                    So ManagEnv is built to help with all that. Environment settings can be managed through the web interface, and exported into a
                    .env file for consumption. Exporting is built into a CLI to allow for scripted deployment.
                    </p>
                    <h2>Requirements</h2>
                    <ul>
                    <li>PHP >=5.5 Installed</li>
                    <li>A SQL Installation. The flavor shouldn't matter much, but I know MySQL is currently working.</li>
                    <li>A Web Server such as Apache or Nginx if you want to use the Web Component</li>
                    </ul>

                    <h2>Usage</h2>
                    <p>
                    The project has both a Web Interface and a CLI component, and can be used both independently or with a small group.
                    It should be hosted on a Private Server for only your collegues to access: Currently it is trivially easy to sign up for
                    an account and view all environment values. This will be changed in an upcoming version.
                    </p>
                    <p>
                    The web interface is pretty barebones. You can create a new environment, which may inherit values from a parent. Adding and editing
                    values is as simple as typing in the textboxes.
                    </p>
                    <p>
                    Environment variable names are always converted to all caps. This is usually standard for .env files. You can download a .env file by
                    clicking the save button in the corner of any environment.
                    </p>
                    <p>
                    The CLI currently allows only exporting .env files. More features are planned. The command line structure for that call:
                    </p>
                    <h4>
                    php artisan env:export {environment name} {file location}
                    </h4>
                    <h2>Planned Features</h2>
                    <ul>
                        <li>Expanding the CLI interface with Import, Get, and Set Functions</li>
                        <li>Generate .env.example files from both interfaces</li>
                        <li>Color/Symbol Coding of environment levels for easily visible inheritance</li>
                        <li>Updating security to allow the possibility of a semi-public server</li>
                        <li>BASH scripts to simplify the CLI calls</li>
                        <li>Installation script to simplify installation</li>
                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
