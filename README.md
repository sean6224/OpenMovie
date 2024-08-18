# OpenMovie 🎥 - v0.1.0 Sphinx
> [!NOTE] The project wiil be restarted soon and will be overwritten again! <3

> [!IMPORTANT]
> :warning: OpenMovie is an open source movie and series streaming platform.

**Discussion of project:**
> OpenMovie was designed with ease of use and performance in mind. Our goal is to create a streaming platform that is competitive with commercial services but remains open and accessible to the community.

> On our discord, you will find future updates and more information about the project.
> [**Join our Discord community here!**](https://discord.gg/yS34uVX62N)

## Table of Contents
>- [Technology stack](#technology-stack-)
>- [Installation](#installation-)
>- [How to use](#how-to-use-)
>- [Contributing to the project](#contributing-to-the-project-)
>- [License](#license)

## Technology stack 🛠️
> [!NOTE]
> This project uses various technologies. Below is a list of the most important elements of our technology stack.
>### Frontend
> ### Currently, there is no first are working on Backend
>### Backend
> - Symfony
> - API Platform - Create, document, and manage APIs with ease.
> - Traefik - Flexible proxy to handle network traffic.
>
> ### Architecture
> - DDD (Domain-Driven Design) - Domain-oriented code organization.
> - CQRS (Command Query Responsibility Segregation)

## Installation 💻
> ### :warning: Very Important:
>### At the moment, we do not have the frontend ready. We are focusing our efforts on the backend.
>
>### To run the backend modules, follow the instructions below:
>**List Command**
>> entire list of commands to use
>>```bash
>> make help
>>```
>**List Modules**
>> Checking the list of modules
>>```bash
>> make list_modules
>>```
>>
> 1.  **Read License**
>>Use the following command to read the license:
>>```bash
>> make read_license
>>```
>>:warning: **Important:** Make sure to execute this command first; otherwise, it will prevent you from using other commands.
> 2.  **Installation of required components**
>>Use the following command to install everything you need:
>>```bash
>> make install
>>```
>> - Once installation is complete, the Service will run itself.
>> - To install a specific module, replace `MODULE_FOLDER` with the desired module name:
>>```bash
>> make install MODULE_FOLDER
>>```
> 3.  **Launching Service**
>>Use the following command to start the service:
>>```bash
>> make start
>>```
>> - To start a specific module, replace `MODULE_FOLDER` with the desired module name:
>>```bash
>> make start MODULE_FOLDER
>>```
> 4.  **Stopping Service**
>>You can stop the service at any time with the following command:
>>```bash
>> make stop
>>```
>> - To stop a specific module, replace `MODULE_FOLDER` with the desired module name:
>>```bash
>> make stop MODULE_FOLDER
>>```

## How to use 🚀
>
> **How to get access to the API?**
> - Open your web browser.
> - Copy and paste the following URL into your browser's address bar `https://api.openmovie.localhost/`
> - Alternatively, [click here](https://api.openmovie.localhost/) to open directly.
>
> **How to get access to the Traefik interface?**
> - Open your web browser.
> - Copy and paste the following URL into your browser's address bar: `https://traefik.openmovie.localhost/`
> - Alternatively, [click here](https://traefik.openmovie.localhost/) to open directly.
>
> Finished! Now you should see the Traefik dashboard. You can use the tools to monitor network traffic, analyze performance, manage routing configuration, and renew SSL certificates.

## Contributing to the project 👋
> [!TIP]
>
> We are glad that you are interested in contributing to our project! Here are a few different ways you can contribute.
>### 🐛 Reporting bugs.
>>If you found a bug in the project, you can help us fix it! Please report any problems through the ticket system on GitHub. Be sure to describe the problem you encountered in detail, allowing us to reproduce it.
>### 📖 Improve documentation.
>>Great documentation makes it easier to use and contribute to the project. If you've noticed a place that could benefit from further documentation or would like to add new documentation, we look forward to your pull requests.
>### 💡 Suggestions for improvement
>>Do you have ideas on how to improve our project? Your insights are valuable to us. Please add your requests and ideas in the submissions section on GitHub.
>### 💻 Code Contributions
>>Helping us develop our project through programming is incredibly valuable. Whether it's fixing bugs, adding new features, or improving code, your changes help us grow. It's always a good idea to familiarize yourself with our code guidelines before proceeding.
>
>Regardless of the type of your contribution, it is valuable, and we appreciate your input. Thank you for helping us build OpenMovie!

> [!IMPORTANT]
>  ## License
>This project is licensed under the Mozilla Public License 2.0 - see [LICENSE.md](LICENSE.md) for details.
>
> We would like to remind you that under the MPL 2.0 license, if you make changes and share the source of your work, you must always provide the real author of the original code. This allows authors to receive credit for their work.
