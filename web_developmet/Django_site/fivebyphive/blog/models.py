from django.db import models

# Create your models here.

# inherits from models class, it is a child class which means
# it has all of the methods within the models class
class posts(models.Model):

	author = models.CharField(max_length = 30)  # has a required property  = max length
	title = models.CharField(max_length = 100)
	bodytext = models.TextField()
	timestamp = models.DateTimeField()
	