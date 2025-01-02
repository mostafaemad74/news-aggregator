# News Aggregator Backend Project

This README file provides an overview of the News Aggregator backend project, outlining its functionality, setup instructions, and implementation details.

## **Project Description**

The News Aggregator is a backend service built using **Laravel** to aggregate articles from multiple news sources. It fetches data from external APIs, stores it in a local database, and provides endpoints for frontend interaction, including filtering, searching, and pagination of news articles.

## **Features**
- Fetch articles from external news sources (e.g., NewsAPI, BBC, The New York Times).
- Store articles in a local database to reduce redundant API calls.
- Provide API endpoints for:
  - Fetching all articles.
  - Searching and filtering articles by category, source, author, or keyword.
  - Pagination of results.
- Regularly update articles using Laravel’s scheduler.

## **Requirements**

- PHP (v8.1 or higher)
- Composer
- MySQL (or any other database supported by Laravel)
- Laravel (v10 or higher)
- API keys for NewsAPI, BBC, and The New York Times (or your selected APIs)

## **Setup Instructions**

### 1. Clone the Repository
```bash
git clone <repository_url>
cd news-aggregator
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Set Up the Environment
Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```
Edit the `.env` file to configure database and API keys:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_aggregator
DB_USERNAME=root
DB_PASSWORD=password

NEWSAPI_KEY=d0be2fd8f7684a34a6e46cfb663b0ae7
GUARDIAN_API_KEY=8gIUBmjXuQUQtyWzaSDhRpiDHcRRJhBK
```

### 4. Run Migrations
Create the database tables:
```bash
php artisan migrate
```

### 5. Test the Application
Fetch data manually to test:
```bash
php artisan schedule:run
```

## **Implementation Details**

### **Fetching Data**

**Services** are responsible for interacting with external APIs and storing articles in the database:
- **NewsApiService**: Fetches data from NewsAPI.
- **BbcNewsApiService**: Fetches data from BBC.
- **NewYorkNewsApiService**: Fetches data from The New York Times.

Each service uses Laravel’s HTTP client to make API requests and saves articles using a centralized `ArticleSaverService`.

### **Database Schema**
The `articles` table schema includes:
- `id`: Primary key
- `title`: Title of the article
- `description`: Short description
- `url`: Link to the original article
- `url_to_image`: URL to the article’s image
- `source`: Source of the article (e.g., BBC)
- `author`: Author of the article
- `category`: Category of the article (e.g., Technology, Sports)
- `published_at`: Datetime when the article was published
- `created_at` and `updated_at`: Timestamps

### **API Endpoints**
Defined in `routes/api.php`:

1. **Fetch all articles**:
   - `GET /api/articles`
   - Supports pagination.

2. **Search and filter articles**:
   - `GET /api/articles/search`
   - Query parameters:
     - `category`
     - `source`
     - `author`
     - `keyword`
     - `start_date`
     - `end_date`
   - Example: `/api/articles/search?category=technology&source=BBC&keyword=AI`

### **Scheduler**
Laravel’s scheduler periodically updates articles from the APIs. The command `fetch-news-command` is scheduled to run every minute:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('fetch-news-command')->everyMinute();
}
```

To test locally, you can run:
```bash
php artisan schedule:run
```

### **Error Handling**
- API call failures are logged to `storage/logs/laravel.log`.

## **Testing**

- **Manual Testing**: Use tools like Postman to test API endpoints.
- Example request:
  ```bash
  curl -X GET "http://localhost/api/articles/search?category=technology" -H "Accept: application/json"
  ```

## **Best Practices Followed**
- DRY: Reused logic through `ArticleSaverService`.
- SOLID: Separate responsibilities for fetching, saving, and processing data.
- Validation: Ensured clean data inputs and handled API responses gracefully.

## **Future Improvements**
- Add user authentication to personalize article preferences.
- Enhance filtering and sorting options.
- Integrate additional news APIs for more content diversity.

## **Resources**
- [NewaApi & BBC](https://newsapi.org/)
- [The New York Times](https://developer.nytimes.com/).
