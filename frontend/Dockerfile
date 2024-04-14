FROM node:14-alpine

WORKDIR /app

COPY package.json package-lock.json /app/

RUN npm install

COPY . /app

RUN npm build

CMD ["npm", "start"]
