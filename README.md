This Real Estate Agent Monitoring API has been developed based on finding a solution to the problem faced by real estate agent companies. Usually, agent companies show their properties to different customers by organizing appointments. Specific agents are responsible to manage those customers and their appointments. Agents’ people keep all the customer records in their contact list. 
Here in this API, an agent can get register himself and manage his customers as well as their appointments.  The Installation guide and all the features of this APP are listing below-
-	[Application Features](##features)
-	[Technical Features](##technical-features)
-	[Installation Guide](##installation)
-	[User Registration](##registration)
-	[User Login](##login)
-	[User Profile](##profile)
-	[User Logout](##logout)
-	[Add Contacts](##add-contact)
-	[Contact Lists](##contact-list)
-	[Contact Detail View](##contact-detail)
-	[Update Contact](##update-contact)
-	[Delete Contact](##delete-contact)
-	[Add Appointment](##add- appointment)
-	[Appointment Lists](## appointment -list)
-	[Appointment Detail View](## appointment -detail)
-	[Update Appointment](##update- appointment)
-	[Delete Appointment](##delete-appointment)
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
•	Get the application from [GitHub link](https://github.com/RaihanulHoque/realestate_appointment.git)
•	Run the composer to the application folder `composer install` 
•	Copy the .env file from the example file `cp .env.example .env`
•	Generate the artisan key `php artisan key:generate`
•	Create a database and rename the database name into the .env file and run the migration command `php artisan migrate`
•	Generate the JWT Secret code by `php artisan jwt:secret`
•	clear your application cache by `php artisan clear-compiled`
•	Recreate boostrap/cache/compiled.php by `php artisan optimize`
•	Run the application `php artisan serve`
•	Go to link and access the application `localhost:8000`



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
