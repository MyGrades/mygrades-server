# MyGrades server

MyGrades server is used as the backend for the Android app [MyGrades](https://github.com/MyGrades/mygrades-app). It is written in PHP using the Laravel framework.

Its two main purposes are:
* define [rules](https://github.com/MyGrades/mygrades-server/tree/master/database/seeds/universities) on how to scrape a students grades for specific universities
* serve these rules via a simple REST api to the clients

It is important to note, that the server does not receive or store any information about the user such as the username or password, nor his or her grades. These will be used solely on the client.