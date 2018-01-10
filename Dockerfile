FROM tutum/lamp:latest
RUN rm -fr /app
ADD . /app
EXPOSE 80 3306
CMD ["/run.sh"]
