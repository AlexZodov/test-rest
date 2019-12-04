## Test REST api project

# Task
Необходимо реализовать REST API для управления библиотекой. Клиент системы должен иметь возможность добавить книгу, авторов, категорию. Получать списки книг, авторов, категорий. Осуществлять поиск и сортировку книг по названию, авторам, категориям. Редактировать категории к которым относится книга.

Требования:

framework: Laravel >= 5.8

db: mysql

--------------------------------------------------------------------------
Implement the REST API to manage the library. The client of the system should be able to add a book, authors, category. Receive lists of books, authors, categories. Search and sort books by title, authors, categories. Edit categories the book belongs to.

Requirements:

framework: Laravel> = 5.8

db: mysql

# Initial instructions
 `php artisan migrate` - run migrations
 
 `php artisan db:seed` - seed tables with faked data (10 authors, 10 categories, 50 books randomly relying upon created authors and categories)
 
# Usage
 
 Retrieving single item data:
 
 GET `/test-api/book/2`
 
 GET `/test-api/author/2`
 
 GET `/test-api/category/2`
 
 
 Creating items:
 
 POST `/test-api/book`, Payload: `[title, author_id, category_id]`, Content-type: `application/x-www-form-urlencoded`
 
 POST `/test-api/author`, Payload: `[first_name, last_name, name_prefix]`, Content-type: `application/x-www-form-urlencoded`
 
 POST `/test-api/category`, Payload: `[name]`, Content-type: `application/x-www-form-urlencoded`
 
 Updating items:
  
 PUT `/test-api/book`, Payload: `[category_id]`, Content-type: `application/x-www-form-urlencoded`
  
 PUT `/test-api/author`, Payload: `[first_name, last_name, name_prefix]`, Content-type: `application/x-www-form-urlencoded`
  
 PUT `/test-api/category`, Payload: `[name]`, Content-type: `application/x-www-form-urlencoded`
 
 Deleting items:
  
 DELETE `/test-api/book/2`
  
 DELETE `/test-api/author/2`
  
 DELETE `/test-api/category/2`
 
 Querying filtering params(example):
 
 GET `/test-api/book?order={"column":"name","dir":"desc"}&search={"first_name":"Aryanna","name":"category_WLFJHP","title":"TITLE"}&page=1&size=6`
  
 order param - define column and direction, in form: `{"column":"name","dir":"desc"}`
  
 or
 
 `{"column":"name","dir":"DESC"}`
 
 search param - define column-value pair for each desired search, in form: 
 
 `{"first_name":"Aryanna","name":"category_WLFJHP","title":"TITLE"}`
 
 
 or
 
 `{"id":2,"name":"category_WLFJHP","title":"TITLE"}`
 
 page & size params - define desired page and page size for pagination logic, by default(if not provided in query) assumed page=1, size=10
 
