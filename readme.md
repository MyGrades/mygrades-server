# MyGrades server

MyGrades server is used as the backend for the Android app [MyGrades](https://github.com/MyGrades/mygrades-app). It is written in PHP using the Laravel framework.

Its two main purposes are:
* define [rules](https://github.com/MyGrades/mygrades-server/tree/master/database/seeds/universities) on how to scrape a students grades for specific universities
* serve these rules via a simple REST api to the clients

It is important to note, that the server does not receive or store any information about the user such as the username or password, nor his or her grades. These will be used solely on the client.

## License

This project is licensed under the [Apache Software License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).

See [`LICENSE`](LICENSE) for more information.

    Copyright 2015 Jonas Theis, Tilman Ginzel

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.