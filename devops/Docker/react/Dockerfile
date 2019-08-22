FROM node

WORKDIR /usr/app

COPY front/package*.json ./

RUN npm install -qy

COPY front/ ./

EXPOSE 3000

CMD ["npm", "start"]
