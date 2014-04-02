# This is the first exercise in the machine learning course. 
# This excercise implements an machine learning example 
# using linear regression. 

import numpy as np
import scipy as sp
import matplotlib.pyplot as plt

# load and assign initial data
# data has dimension n rows = 2 columns
data = sp.genfromtxt("ex1data1.txt",delimiter=",")

# preprocess and clean data
# separate dimensions into two vectors of equal size
# X = population
# Y = profit
X = data[:,0] # first column
Y = data[:,1] # second column
m = Y.size # m = number of training examples

# check data with a plot
plt.scatter(X,Y, marker="x", c="red") # first argument = x-axis , second argument = y-axis
plt.title ("Profit vs Population for restaurant") # title
plt.xlabel("Population") # xlabel
plt.ylabel("Profit") #ylabel
plt.autoscale(tight=True) # automatically scales graph to data
#plt.grid() # shows grid on graph
#plt.show() # necessary to print graph


# prep data and variables for linear regression
x = np.ones((m,1)) # create column of ones
X = np.reshape(X,(m,1)) # reshape X to a vector
X = np.c_[x,X] # insert column of ones

iterations = 1500
alpha = 0.01


print X