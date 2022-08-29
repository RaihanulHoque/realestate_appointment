<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RealEstate Appointment Management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .para-link{
                font-weight: bold;
                color: #0c93e4;
            }
            .headline{
                border-bottom: 1px solid #b4b4b6b7
            }
            .markdown {
                background-color: #FCFCFC;
                border: 1px solid #e5e5e5;
                border-radius: 4px;
                padding: 30px;
                padding-top: 70px;
                position: relative;
                word-wrap: break-word;
            }
            .markdown pre {
                padding: 10px 20px;
                overflow: auto;
                background-color: #e2e2fffb;
                border-radius: 4px;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .markdown pre, .markdown code {
                border-radius: 4px;
                background-color: #e2e2fffb;
                overflow: auto;
                font-family: monospace, monospace;
                line-height: 1.47em;
                vertical-align: middle;
            }
            pre code {
                padding: 0;
            }
            code {
                /* display: inline-block; */
                padding: 0 5px;
                border-radius: 3px;
            }
        </style>
    </head>
    <body class="antialiased">

        <div class="container-sm">


            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="stackedit__html markdown">
                    <h1 align="center">Real Estate Agent Monitoring Application Backend</h1>
                    <p align="center">
                        <a href="http://docs.vapor.codes/3.0/">
                            <img src="https://img.shields.io/github/followers/raihanulhoque?style=plat" alt="Documentation">
                        </a>
                        <a href="https://discord.gg/vapor">
                            <img src="https://img.shields.io/github/repo-size/raihanulhoque/realestate_appointment?color=gree" alt="Team Chat">
                        </a>
                        <a href="LICENSE">
                            <img src="http://img.shields.io/badge/license-MIT-brightgreen.svg" alt="MIT License">
                        </a>
                        <a href="https://twitter.com/raihansabuj1">
                            <img src="https://img.shields.io/twitter/follow/raihansabuj1?style=social" alt="Swift 5.1">
                        </a>
                        <a href="https://www.linkedin.com/in/raihanulhoque/" >
                            <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white" alt="Swift 5.1" style='height:20px'>
                        </a>
                    </p>
                    This Real Estate Agent Monitoring API has been developed based on finding a solution to the problem faced by real estate agent companies. Usually, agent companies show their properties to different customers by organizing appointments. Specific agents are responsible to manage those customers and their appointments. Agents’ people keep all the customer records in their contact list.
                    <p>Here in this API, an agent can get register himself and manage his customers as well as their appointments.  The Installation guide and all the features of this APP are listing below-</p>
                    <ul>
                    <li><a class="para-link" href="#application-features">Application Features</a></li>
                    <li><a class="para-link" href="#technical-features">Technical Features</a></li>
                    <li><a class="para-link" href="#installation-guide">Installation Guide</a></li>
                    <li><a class="para-link" href="#user-registration">User Registration</a></li>
                    <li><a class="para-link" href="#user-login">User Login</a></li>
                    <li><a class="para-link" href="#user-profile">User Profile</a></li>
                    <li><a class="para-link" href="#user-logout">User Logout</a></li>
                    <li><a class="para-link" href="#add-contact">Add Contacts</a></li>
                    <li><a class="para-link" href="#contact-list">Contact List</a></li>
                    <li><a class="para-link" href="#contact-detail-view">Contact Detail View</a></li>
                    <li><a class="para-link" href="#update-contact">Update Contact</a></li>
                    <li><a class="para-link" href="#delete-contact">Delete Contact</a></li>
                    <li><a class="para-link" href="#add-appointment">Add Appointment</a></li>
                    <li><a class="para-link" href="#appointment-list">Appointment List</a></li>
                    <li><a class="para-link" href="#appointment-detail-view">Appointment Detail View</a></li>
                    <li><a class="para-link" href="#update-appointment">Update Appointment</a></li>
                    <li><a class="para-link" href="#delete-appointment">Delete Appointment</a></li>
                    </ul>
                    <h2 class="headline"  id="application-features">Application Features</h2>
                    <ul>
                    <li>This API facilitated Agent User Registration/Login/Logout system. User registration required fields are: name, email, phone, address, and password. The address should be only VALID ZIP CODE (Max:7 Characters). Here, a default zip code is provided as CM27PJ for all Agent’s Registration, considering it as the address of Agent Office.</li>
                    <li>An agent can add customer information as their contact list. Contact information will be adding based on name, surname, email, address, and phone. Agent can update or delete any contact if required.</li>
                    <li>Agents can create Appointments for specific Location (considering as ‘Appointment Address’) with specific customer from their contact list. The default appointment duration is considering as -one hour.</li>
                    <li>The distance between agent’s office location and the appointment location can be measured. Agent can find estimated time duration before joining the appointment. So that h/she can have an idea about the departure time from the office based on his appointment start time.</li>
                    <li>After one hour of the appointment, agent can have an idea about the estimated arrival time duration to come back to his/her office.</li>
                    <li>All the distance and communication duration are measuring by Google Maps API.</li>
                    <li>Agent can manage their appointments (Add, Update, delete)</li>
                    </ul>
                     <h2 class="headline" id="technical-features">Technical Features</h2>
                    <ul>
                    <li>PHP Framework Laravel-8.75 is used to make this backend application.</li>
                    <li>JSON Web Token Authentication (jwt-auth) is used to manage token based authentication system.  JWT generates a secured three part JSON Web Token. These three parts are separated by ‘.’ (dot) and each section is created differently. The first part of the token hold the header information, second part hold payload information and the last part of the token hold signature. This signature is made up of a hash of the header, the payload and the secret. This is the final part of the whole token.</li>
                    <li>The application designed and developed on RESTful API and data transfer environment.</li>
                    <li>Google Maps API is used to measure distance between two zip code location and to get time duration for transporting between them. Initially UK based zip codes (6 characters) are processing for calculation process.</li>
                    <li><a href="https://www.getpostman.com/collections/b0987d47a462d745928d">POSTMAN collection folder</a> is provided for usages reference.</li>
                    </ul>
                     <h2 class="headline" id="installation-guide">Installation Guide</h2>
                    <ul>
                    <li>Get the application from <a href="https://github.com/RaihanulHoque/realestate_appointment.git" style="font-weight: bold; color:#0c93e4">GitHub link</a></li>
                    <li>Run the composer to the application folder <code>composer install</code></li>
                    <li>Copy the .env file from the example file <code>cp .env.example .env</code></li>
                    <li>Generate the artisan key <code>php artisan key:generate</code></li>
                    <li>Create a database and rename the database name into the .env file and run the migration command <code>php artisan migrate</code></li>
                    <li>Generate the JWT Secret code by <code>php artisan jwt:secret</code></li>
                    <li>clear your application cache by <code>php artisan clear-compiled</code></li>
                    <li>Recreate boostrap/cache/compiled.php by <code>php artisan optimize</code></li>
                    <li>Run the application <code>php artisan serve</code></li>
                    <li>Go to link and access the application <code>localhost:8000</code></li>
                    </ul>
                     <h2 class="headline" id="user-registration">User Registration</h2>
                    <h3 id="post-register">POST /register</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/register">http://reappointments.isysolutions.com/api/auth/register</a></p>
                    <p>Response body:</p>
                    <pre>
                        <code>
                                {
                                    "message": "User successfully registered",
                                    "user": {
                                            "name": "Md Raihanul",
                                            "email": "raihansabuj@gmail.com",
                                            "phone": "01711239679",
                                            "updated_at": "2022-08-27T04:08:37.000000Z",
                                            "created_at": "2022-08-27T04:08:37.000000Z",
                                            "id": 1
                                        }
                                }
                        </code>
                    </pre>
                    <h2 class="headline" id="user-login">User Login</h2>
                    <h3 id="post-login">POST /login</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/login">http://reappointments.isysolutions.com/api/auth/login</a></p>
                    <p>Response body:</p>
                    <pre>
                        <code>
                            {
                                "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2NjE2MDI3MjAsImV4cCI6MTY2MTYwNjMyMCwibmJmIjoxNjYxNjAyNzIwLCJqdGkiOiJnUDdsaWxuR09hd0NYZXppIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.RK_ltv1VKewt8y8o_Ray-NCTbnRWbNqhuCu31hB1n-k",
                                "token_type": "bearer",
                                "expires_in": 3600,
                                "user": {
                                    "id": 1,
                                    "name": "Md Raihanul",
                                    "phone": "0112312994",
                                    "address": "cm27pj",
                                    "email": "raihansabuj@gmail.com",
                                    "email_verified_at": null,
                                    "created_at": "2022-08-27T04:08:37.000000Z",
                                    "updated_at": "2022-08-27T04:08:37.000000Z"
                                }
                            }
                        </code>
                    </pre>

                    <h2 class="headline" id="user-profile">User Profile</h2>
                    <h3 id="get-user-profile">GET /user-profile</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/user-profile">http://reappointments.isysolutions.com/api/auth/user-profile</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                        <span class="token string">"name"</span><span class="token punctuation">:</span> <span class="token string">"Md Raihanul"</span><span class="token punctuation">,</span>
                        <span class="token string">"phone"</span><span class="token punctuation">:</span> <span class="token string">"0112312994"</span><span class="token punctuation">,</span>
                        <span class="token string">"address"</span><span class="token punctuation">:</span> <span class="token string">"cm27pj"</span><span class="token punctuation">,</span>
                        <span class="token string">"email"</span><span class="token punctuation">:</span> <span class="token string">"raihansabuj@gmail.com"</span><span class="token punctuation">,</span>
                        <span class="token string">"email_verified_at"</span><span class="token punctuation">:</span> null<span class="token punctuation">,</span>
                        <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T04:08:37.000000Z"</span><span class="token punctuation">,</span>
                        <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T04:08:37.000000Z"</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="user-logout">User Logout</h2>
                    <h3 id="post-logout">POST /logout</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/logout">http://reappointments.isysolutions.com/api/auth/logout</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"message"</span><span class="token punctuation">:</span> <span class="token string">"User successfully signed out"</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="add-contact">Add Contact</h2>
                    <h3 id="post-contacts">POST /contacts</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/contacts">http://reappointments.isysolutions.com/api/auth/contacts</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"success"</span><span class="token punctuation">:</span> <span class="token keyword">true</span><span class="token punctuation">,</span>
                        <span class="token string">"contact"</span><span class="token punctuation">:</span> <span class="token punctuation">{</span>
                            <span class="token string">"created_by"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                            <span class="token string">"name"</span><span class="token punctuation">:</span> <span class="token string">"James"</span><span class="token punctuation">,</span>
                            <span class="token string">"surname"</span><span class="token punctuation">:</span> <span class="token string">"Bonds"</span><span class="token punctuation">,</span>
                            <span class="token string">"email"</span><span class="token punctuation">:</span> <span class="token string">"jamesss@gm.com"</span><span class="token punctuation">,</span>
                            <span class="token string">"phone"</span><span class="token punctuation">:</span> <span class="token string">"+44586005"</span><span class="token punctuation">,</span>
                            <span class="token string">"address"</span><span class="token punctuation">:</span> <span class="token string">"LU11AA"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T12:31:36.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T12:31:36.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">1</span>
                        <span class="token punctuation">}</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="contact-list">Contact List</h2>
                    <h3 id="get-contacts">GET /contacts</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/contacts">http://reappointments.isysolutions.com/api/auth/contacts</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">[</span>
                        <span class="token punctuation">{</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                            <span class="token string">"name"</span><span class="token punctuation">:</span> <span class="token string">"James"</span><span class="token punctuation">,</span>
                            <span class="token string">"surname"</span><span class="token punctuation">:</span> <span class="token string">"Bonds"</span><span class="token punctuation">,</span>
                            <span class="token string">"email"</span><span class="token punctuation">:</span> <span class="token string">"jamesss@gm.com"</span><span class="token punctuation">,</span>
                            <span class="token string">"phone"</span><span class="token punctuation">:</span> <span class="token string">"+44586005"</span><span class="token punctuation">,</span>
                            <span class="token string">"address"</span><span class="token punctuation">:</span> <span class="token string">"LU11AA"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_by"</span><span class="token punctuation">:</span> <span class="token string">"1"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T12:31:36.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T12:31:36.000000Z"</span>
                        <span class="token punctuation">}</span><span class="token punctuation">,</span>
                        <span class="token punctuation">{</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
                            <span class="token string">"name"</span><span class="token punctuation">:</span> <span class="token string">"Jashim"</span><span class="token punctuation">,</span>
                            <span class="token string">"surname"</span><span class="token punctuation">:</span> <span class="token string">"Khan"</span><span class="token punctuation">,</span>
                            <span class="token string">"email"</span><span class="token punctuation">:</span> <span class="token string">"JKhan@gm.com"</span><span class="token punctuation">,</span>
                            <span class="token string">"phone"</span><span class="token punctuation">:</span> <span class="token string">"+4491039201"</span><span class="token punctuation">,</span>
                            <span class="token string">"address"</span><span class="token punctuation">:</span> <span class="token string">"LU11BN"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_by"</span><span class="token punctuation">:</span> <span class="token string">"1"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T05:00:43.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T05:19:13.000000Z"</span>
                        <span class="token punctuation">}</span>
                    <span class="token punctuation">]</span>
                    </code></pre>
                     <h2 class="headline" id="contact-detail-view">Contact Detail View</h2>
                    <h3 id="get-contactid">GET /contact/{id}</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/contact/1">http://reappointments.isysolutions.com/api/auth/contact/1</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                        <span class="token string">"name"</span><span class="token punctuation">:</span> <span class="token string">"James"</span><span class="token punctuation">,</span>
                        <span class="token string">"surname"</span><span class="token punctuation">:</span> <span class="token string">"Bond"</span><span class="token punctuation">,</span>
                        <span class="token string">"email"</span><span class="token punctuation">:</span> <span class="token string">"james@gm.com"</span><span class="token punctuation">,</span>
                        <span class="token string">"phone"</span><span class="token punctuation">:</span> <span class="token string">"+44586005"</span><span class="token punctuation">,</span>
                        <span class="token string">"address"</span><span class="token punctuation">:</span> <span class="token string">"LU11AA"</span><span class="token punctuation">,</span>
                        <span class="token string">"created_by"</span><span class="token punctuation">:</span> <span class="token string">"1"</span><span class="token punctuation">,</span>
                        <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:02:55.000000Z"</span><span class="token punctuation">,</span>
                        <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:02:55.000000Z"</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="update-contact">Update Contact</h2>
                    <h3 id="put-contactid">PUT /contact/{id}</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/contact/1">http://reappointments.isysolutions.com/api/auth/contact/1</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"success"</span><span class="token punctuation">:</span> <span class="token keyword">true</span><span class="token punctuation">,</span>
                        <span class="token string">"message"</span><span class="token punctuation">:</span> <span class="token string">"Contact Updated successfully!"</span><span class="token punctuation">,</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="delete-contact">Delete Contact</h2>
                    <h3 id="delete-contactid">DELETE /contact/{id}</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/contact/1">http://reappointments.isysolutions.com/api/auth/contact/1</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"success"</span><span class="token punctuation">:</span> <span class="token keyword">true</span><span class="token punctuation">,</span>
                        <span class="token string">"message"</span><span class="token punctuation">:</span> <span class="token string">"Contact has been deleted"</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="add-appointment">Add Appointment</h2>
                    <h3 id="post-appointments">POST /appointments</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/appointments">http://reappointments.isysolutions.com/api/auth/appointments</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"success"</span><span class="token punctuation">:</span> <span class="token keyword">true</span><span class="token punctuation">,</span>
                        <span class="token string">"appointment"</span><span class="token punctuation">:</span> <span class="token punctuation">{</span>
                            <span class="token string">"user_id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                            <span class="token string">"contact_id"</span><span class="token punctuation">:</span> <span class="token string">"3"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_address"</span><span class="token punctuation">:</span> <span class="token string">"LU11BL"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_date"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-23"</span><span class="token punctuation">,</span>
                            <span class="token string">"measured_distance"</span><span class="token punctuation">:</span> <span class="token string">"93km"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_start_time"</span><span class="token punctuation">:</span> <span class="token string">"12:30:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"departure_time_to_site_office"</span><span class="token punctuation">:</span> <span class="token string">"11:10:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_end_time"</span><span class="token punctuation">:</span> <span class="token string">"13:30:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"arrival_time_to_agent_office"</span><span class="token punctuation">:</span> <span class="token string">"14:50:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:54:32.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:54:32.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">12</span>
                        <span class="token punctuation">}</span>
                    <span class="token punctuation">}</span>
                    </code></pre>
                     <h2 class="headline" id="appointment-list">Appointment List</h2>
                    <h3 id="get-appointments">GET /appointments</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/appointments">http://reappointments.isysolutions.com/api/auth/appointments</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">[</span>
                       <span class="token punctuation">{</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">5</span><span class="token punctuation">,</span>
                            <span class="token string">"contact_id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                            <span class="token string">"user_id"</span><span class="token punctuation">:</span> <span class="token string">"1"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_address"</span><span class="token punctuation">:</span> <span class="token string">"CM29PJ"</span><span class="token punctuation">,</span>
                            <span class="token string">"measured_distance"</span><span class="token punctuation">:</span> <span class="token string">"2km"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_date"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-25"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_start_time"</span><span class="token punctuation">:</span> <span class="token string">"10:00:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"departure_time_to_site_office"</span><span class="token punctuation">:</span> <span class="token string">"10:10:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_end_time"</span><span class="token punctuation">:</span> <span class="token string">"11:00:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"arrival_time_to_agent_office"</span><span class="token punctuation">:</span> <span class="token string">"11:10:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:00:41.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:00:41.000000Z"</span>
                        <span class="token punctuation">}</span><span class="token punctuation">,</span>
                        <span class="token punctuation">{</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">7</span><span class="token punctuation">,</span>
                            <span class="token string">"contact_id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                            <span class="token string">"user_id"</span><span class="token punctuation">:</span> <span class="token string">"1"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_address"</span><span class="token punctuation">:</span> <span class="token string">"cm27pj"</span><span class="token punctuation">,</span>
                            <span class="token string">"measured_distance"</span><span class="token punctuation">:</span> <span class="token string">"2.5km"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_date"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-26"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_start_time"</span><span class="token punctuation">:</span> <span class="token string">"12:00:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"departure_time_to_site_office"</span><span class="token punctuation">:</span> <span class="token string">"12:15:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_end_time"</span><span class="token punctuation">:</span> <span class="token string">"13:15:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"arrival_time_to_agent_office"</span><span class="token punctuation">:</span> <span class="token string">"13:30:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:08:44.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:08:44.000000Z"</span>
                        <span class="token punctuation">}</span><span class="token punctuation">,</span>
                    <span class="token punctuation">]</span>
                    </code></pre>
                     <h2 class="headline" id="appointment-detail-view">Appointment Detail View</h2>
                    <h3 id="get-appointmentid">GET /appointment/{id}</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/appointment/12">http://reappointments.isysolutions.com/api/auth/appointment/12</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby">    <span class="token punctuation">{</span>
                            <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">12</span><span class="token punctuation">,</span>
                            <span class="token string">"user_id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
                            <span class="token string">"contact_id"</span><span class="token punctuation">:</span> <span class="token string">"3"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_address"</span><span class="token punctuation">:</span> <span class="token string">"LU11BL"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_date"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-23"</span><span class="token punctuation">,</span>
                            <span class="token string">"measured_distance"</span><span class="token punctuation">:</span> <span class="token string">"93km"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_start_time"</span><span class="token punctuation">:</span> <span class="token string">"12:30:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"departure_time_to_site_office"</span><span class="token punctuation">:</span> <span class="token string">"11:10:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"appointment_end_time"</span><span class="token punctuation">:</span> <span class="token string">"13:30:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"arrival_time_to_agent_office"</span><span class="token punctuation">:</span> <span class="token string">"14:50:00"</span><span class="token punctuation">,</span>
                            <span class="token string">"updated_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:54:32.000000Z"</span><span class="token punctuation">,</span>
                            <span class="token string">"created_at"</span><span class="token punctuation">:</span> <span class="token string">"2022-08-27T09:54:32.000000Z"</span>
                        <span class="token punctuation">}</span>

                    </code></pre>
                     <h2 class="headline" id="update-appointment">Update Appointment</h2>
                    <h3 id="put-appointmentid">PUT /appointment/{id}</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/appointment/12">http://reappointments.isysolutions.com/api/auth/appointment/12</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"success"</span><span class="token punctuation">:</span> <span class="token keyword">true</span><span class="token punctuation">,</span>
                        <span class="token string">'message'</span><span class="token operator">=</span><span class="token operator">&gt;</span><span class="token string">'Appointment updated successfully!'</span><span class="token punctuation">,</span>
                    <span class="token punctuation">}</span>

                    </code></pre>
                     <h2 class="headline" id="delete-appointment">Delete Appointment</h2>
                    <h3 id="delete-appointmentid">DELETE /appointment/{id}</h3>
                    <p>Example Link: <a href="http://reappointments.isysolutions.com/api/auth/appointment/12">http://reappointments.isysolutions.com/api/auth/appointment/12</a></p>
                    <p>Response body:</p>
                    <pre class=" language-ruby"><code class="prism  language-ruby"><span class="token punctuation">{</span>
                        <span class="token string">"success"</span><span class="token punctuation">:</span> <span class="token keyword">true</span><span class="token punctuation">,</span>
                        <span class="token string">"message"</span><span class="token punctuation">:</span> <span class="token string">"The appointment has been deleted"</span>
                    <span class="token punctuation">}</span>

                    </code></pre>
                    </div>
            </div>
        </div>
    </body>
</html>
