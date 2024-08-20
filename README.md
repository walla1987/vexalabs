### Setting Up Project Locally 

A Docker environment was setup to create a uniform environment for developers.

- Clone the repository.
- Copy .env.example to .env within root directory
- set QUEUE_CONNECTION=database AND DB_HOST=mysql within the newly created .env file
- Run docker compose up --build -d
- Access application using http://localhost

### Running migrations
- docker exec -it `<container-name>` php artisan migrate

### Install application dependencies
- docker exec -it `<container-name>` composer install 

### Generating application key 
- docker exec -it `<container-name>` php artisan key:generate

### Queue worker
- The queue worker is set up with supervisor which happens during the docker-compose process.
- Ensure QUEUE_CONNECTION within your .env file is set to database.


## API Documentation

### Creates a new campaign.
#### Request
`POST /api/campaigns`

    curl -X POST http://localhost/api/campaigns \
     -H "Accept: application/json" \
     -d 'client_id=1&name=Campaign A&start_date=2024-11-06 12:00:00&end_date=2024-11-12 12:00:00'

#### Response

    HTTP/1.1 201 Created
    Date: Mon, 19 Aug 2024 12:36:30 SAST
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /api/campaigns
    Content-Length: 36

```json
{"data": {
    "id":1,
    "client_id":1,
    "name": "Campaign A",
    "start_date": "2024-11-06 12:00:00",
    "end_date": "2024-11-12 12:00:00",
    "created_at": "2024-08-20T14:06:49.000000Z",
    "updated_at": "2024-08-20T14:06:49.000000Z"
  }
}
```
### Adds user data to a campaign.
#### Request
`POST /api/campaigns/{campaign_id}/data`

    curl -X POST http://localhost/api/campaigns/1/data \
     -H "Accept: application/json" \
     -d 'user_data[0][user_id]=1' \
     -d 'user_data[0][video_url]=http://video-url' \
    -d 'user_data[0][custom_fields]={"foo":"bar"}'
### Response
    HTTP/1.1 202 Accepted
    Server: nginx/1.26.1
    Content-Type: application/json
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-Powered-By: PHP/8.3.10
    Cache-Control: no-cache, private
    Date: Tue, 20 Aug 2024 15:06:21 GMT
    X-RateLimit-Limit: 60
    X-RateLimit-Remaining: 58
    Access-Control-Allow-Origin: *
```json
[]
```

### Test cases 
* **Code Robustness**: Tests help in identifying bugs and issues, ensuring that the code handles various scenarios and edge cases gracefully.
* **Confidence**: Tests provide assurance that changes or new features do not break existing functionality, giving developers and stakeholders confidence in the application's stability.

To run the test cases, run the following commmand within the app container.
`./vendor/bin/phpunit `
