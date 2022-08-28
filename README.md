# Real Estate Agent Monitoring Application Backend

This Real Estate Agent Monitoring API has been developed based on finding a solution to the problem faced by real estate agent companies. Usually, agent companies show their properties to different customers by organizing appointments. Specific agents are responsible to manage those customers and their appointments. Agents’ people keep all the customer records in their contact list. 
Here in this API, an agent can get register himself and manage his customers as well as their appointments.  The Installation guide and all the features of this APP are listing below-
-	[Application Features](#application-features)
-	[Technical Features](#technical-features)
-	[Installation Guide](#installation-guide)
-	[User Registration](#user-registration)
-	[User Login](#user-login)
-	[User Profile](#user-profile)
-	[User Logout](#user-logout)
-	[Add Contacts](#add-contact)
-	[Contact List](#contact-list)
-	[Contact Detail View](#contact-detail-view)
-	[Update Contact](#update-contact)
-	[Delete Contact](#delete-contact)
-	[Add Appointment](#add-appointment)
-	[Appointment List](#appointment-list)
-	[Appointment Detail View](#appointment-detail-view)
-	[Update Appointment](#update-appointment)
-	[Delete Appointment](#delete-appointment)

##  Application Features
-	This API facilitated Agent User Registration/Login/Logout system. User registration required fields are: name, email, phone, address, and password. The address should be only VALID ZIP CODE (Max:7 Characters). Here, a default zip code is provided as CM27PJ for all Agent’s Registration, considering it as the address of Agent Office.
-	An agent can add customer information as their contact list. Contact information will be adding based on name, surname, email, address, and phone. Agent can update or delete any contact if required.
-	Agents can create Appointments for specific Location (considering as ‘Appointment Address’) with specific customer from their contact list. The default appointment duration is considering as -one hour. 
-	The distance between agent’s office location and the appointment location can be measured. Agent can find estimated time duration before joining the appointment. So that h/she can have an idea about the departure time from the office based on his appointment start time. 
-	After one hour of the appointment, agent can have an idea about the estimated arrival time duration to come back to his/her office. 
-	All the distance and communication duration are measuring by Google Maps API. 
-	Agent can manage their appointments (Add, Update, delete)

## Technical Features
-	PHP Framework Laravel-8.75 is used to make this backend application. 
-	JSON Web Token Authentication (jwt-auth) is used to manage token based authentication system.  JWT generates a secured three part JSON Web Token. These three parts are separated by ‘.’ (dot) and each section is created differently. The first part of the token hold the header information, second part hold payload information and the last part of the token hold signature. This signature is made up of a hash of the header, the payload and the secret. This is the final part of the whole token. 
-	The application designed and developed on RESTful API and data transfer environment. 
-	Google Maps API is used to measure distance between two zip code location and to get time duration for transporting between them. Initially UK based zip codes (6 characters) are processing for calculation process. 
-	[POSTMAN collection folder]( https://www.getpostman.com/collections/b0987d47a462d745928d) is provided for usages reference. 

## Installation Guide
*	Get the application from [GitHub link](https://github.com/RaihanulHoque/realestate_appointment.git)
*	Run the composer to the application folder `composer install` 
*	Copy the .env file from the example file `cp .env.example .env`
*	Generate the artisan key `php artisan key:generate`
*	Create a database and rename the database name into the .env file and run the migration command `php artisan migrate`
*	Generate the JWT Secret code by `php artisan jwt:secret`
*	clear your application cache by `php artisan clear-compiled`
*	Recreate boostrap/cache/compiled.php by `php artisan optimize`
*	Run the application `php artisan serve`
*	Go to link and access the application `localhost:8000`


## User Registration 
### POST /register
Example Link: http://127.0.0.1:8000/api/auth/register

Response body:
```ruby
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
```

## User Login 
### POST /login
Example Link: http://127.0.0.1:8000/api/auth/login

Response body:
```ruby
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
```



## User Profile 
### GET /user-profile
Example Link: http://127.0.0.1:8000/api/auth/user-profile

Response body:
```ruby
{
    "id": 1,
    "name": "Md Raihanul",
    "phone": "0112312994",
    "address": "cm27pj",
    "email": "raihansabuj@gmail.com",
    "email_verified_at": null,
    "created_at": "2022-08-27T04:08:37.000000Z",
    "updated_at": "2022-08-27T04:08:37.000000Z"
}
```



## User Logout 
### POST /logout
Example Link: http://127.0.0.1:8000/api/auth/logout

Response body:
```ruby
{
    "message": "User successfully signed out"
}
```




## Add Contact
### POST /contacts
Example Link: http://127.0.0.1:8000/api/auth/contacts

Response body:
```ruby
{
    "success": true,
    "contact": {
        "created_by": 1,
        "name": "James",
        "surname": "Bonds",
        "email": "jamesss@gm.com",
        "phone": "+44586005",
        "address": "LU11AA",
        "updated_at": "2022-08-27T12:31:36.000000Z",
        "created_at": "2022-08-27T12:31:36.000000Z",
        "id": 1
    }
}
```


## Contact List
### GET /contacts
Example Link: http://127.0.0.1:8000/api/auth/contacts

Response body:
```ruby
[
    {
        "id": 1,
        "name": "James",
        "surname": "Bonds",
        "email": "jamesss@gm.com",
        "phone": "+44586005",
        "address": "LU11AA",
        "created_by": "1",
        "created_at": "2022-08-27T12:31:36.000000Z",
        "updated_at": "2022-08-27T12:31:36.000000Z"
    },
    {
        "id": 2,
        "name": "Jashim",
        "surname": "Khan",
        "email": "JKhan@gm.com",
        "phone": "+4491039201",
        "address": "LU11BN",
        "created_by": "1",
        "created_at": "2022-08-27T05:00:43.000000Z",
        "updated_at": "2022-08-27T05:19:13.000000Z"
    }
]
```

## Contact Detail View
### GET /contact/{id}
Example Link: http://127.0.0.1:8000/api/auth/contact/1

Response body:
```ruby
{
    "id": 1,
    "name": "James",
    "surname": "Bond",
    "email": "james@gm.com",
    "phone": "+44586005",
    "address": "LU11AA",
    "created_by": "1",
    "created_at": "2022-08-27T09:02:55.000000Z",
    "updated_at": "2022-08-27T09:02:55.000000Z"
}
```


## Update Contact
### PUT /contact/{id}
Example Link: http://127.0.0.1:8000/api/auth/contact/1

Response body:
```ruby
{
    "success": true,
    "message": "Contact Updated successfully!",
}
```


## Delete Contact
### DELETE /contact/{id}
Example Link: http://127.0.0.1:8000/api/auth/contact/1

Response body:
```ruby
{
    "success": true,
    "message": "Contact has been deleted"
}
```


## Add Appointment
### POST /appointments
Example Link: http://127.0.0.1:8000/api/auth/appointments

Response body:
```ruby
{
    "success": true,
    "appointment": {
        "user_id": 1,
        "contact_id": "3",
        "appointment_address": "LU11BL",
        "appointment_date": "2022-08-23",
        "measured_distance": "93km",
        "appointment_start_time": "12:30:00",
        "departure_time_to_site_office": "11:10:00",
        "appointment_end_time": "13:30:00",
        "arrival_time_to_agent_office": "14:50:00",
        "updated_at": "2022-08-27T09:54:32.000000Z",
        "created_at": "2022-08-27T09:54:32.000000Z",
        "id": 12
    }
}
```


## Appointment List
### GET /appointments
Example Link: http://127.0.0.1:8000/api/auth/appointments

Response body:
```ruby
[
   {
        "id": 5,
        "contact_id": 1,
        "user_id": "1",
        "appointment_address": "CM29PJ",
        "measured_distance": "2km",
        "appointment_date": "2022-08-25",
        "appointment_start_time": "10:00:00",
        "departure_time_to_site_office": "10:10:00",
        "appointment_end_time": "11:00:00",
        "arrival_time_to_agent_office": "11:10:00",
        "created_at": "2022-08-27T09:00:41.000000Z",
        "updated_at": "2022-08-27T09:00:41.000000Z"
    },
    {
        "id": 7,
        "contact_id": 1,
        "user_id": "1",
        "appointment_address": "cm27pj",
        "measured_distance": "2.5km",
        "appointment_date": "2022-08-26",
        "appointment_start_time": "12:00:00",
        "departure_time_to_site_office": "12:15:00",
        "appointment_end_time": "13:15:00",
        "arrival_time_to_agent_office": "13:30:00",
        "created_at": "2022-08-27T09:08:44.000000Z",
        "updated_at": "2022-08-27T09:08:44.000000Z"
    },
]
```


## Appointment Detail View
### GET /appointment/{id}
Example Link: http://127.0.0.1:8000/api/auth/appointment/12

Response body:
```ruby
    {
        "id": 12,
        "user_id": 1,
        "contact_id": "3",
        "appointment_address": "LU11BL",
        "appointment_date": "2022-08-23",
        "measured_distance": "93km",
        "appointment_start_time": "12:30:00",
        "departure_time_to_site_office": "11:10:00",
        "appointment_end_time": "13:30:00",
        "arrival_time_to_agent_office": "14:50:00",
        "updated_at": "2022-08-27T09:54:32.000000Z",
        "created_at": "2022-08-27T09:54:32.000000Z"
    }

```


## Update Appointment
### PUT /appointment/{id}
Example Link: http://127.0.0.1:8000/api/auth/appointment/12

Response body:
```ruby
{
    "success": true,
    'message'=>'Appointment updated successfully!',
}

```


## Delete Appointment
### DELETE /appointment/{id}
Example Link: http://127.0.0.1:8000/api/auth/appointment/12

Response body:
```ruby
{
    "success": true,
    "message": "The appointment has been deleted"
}

```
