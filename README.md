# Workspacer

My thesis is about a custom project management tool developed with Laravel backend and Vue frontend. The aim of the project is to create a user-friendly and efficient tool that can help organizations manage their projects effectively. The tool is designed to provide features such as task tracking, team collaboration, and progress monitoring. The Laravel backend provides a robust and secure platform for data storage and processing, while the Vue frontend ensures a smooth and intuitive user experience. The project also includes extensive testing and documentation to ensure the reliability and usability of the tool.

## Customize configuration

Project settings can be edited in the environment file:

```
.env
```

## Project Setup

```sh
docker/sdk build
```

### Start Application

```sh
docker/sdk up
```

### Stop Application

```sh
docker/sdk down
```

### Resume Application

```sh
docker/sdk start
```

### Pause Application

```sh
docker/sdk stop
```

### Run Composer Command in Api Container

```sh
docker/sdk composer <command>
```

### Run Npm Command in Home Container

```sh
docker/sdk npm home <command>
```

### Run Npm Command in App Container

```sh
docker/sdk npm app <command>
```