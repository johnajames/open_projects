# This is the first exercise in the machine learning course. 
# This excercise implements an machine learning example 
# using linear regression. 
import sys

from numpy import * 
import scipy as sp
import matplotlib.pyplot as plt

def hypothesis(X,theta):
	return X.dot(theta)

def computeCost(X,Y,theta):
	m = len(Y)
	term = hypothesis(X,theta) - Y
	return (term.T.dot(term) / (2 * m))[0,0]

# load and assign initial data
# data has dimension n rows = 2 columns
data = genfromtxt("ex1data1.txt",delimiter=",")

# preprocess and clean data
# separate dimensions into two vectors of equal size
# X = population
# Y = profit
X = data[:,0] # first column
Y = data[:,1] # second column
m = len(Y) # m = number of training examples
Y = Y.reshape(m,1)

X = c_[ones((m,1)),X]

# check data with a plot
# plt.scatter(X,Y, marker="x", c="red") # first argument = x-axis , second argument = y-axis
# plt.title ("Profit vs Population for restaurant") # title
# plt.xlabel("Population") # xlabel
# plt.ylabel("Profit") #ylabel
# plt.autoscale(tight=True) # automatically scales graph to data
#plt.grid() # shows grid on graph
#plt.show() # necessary to print graph


# prep data and variables for linear regression
# X = np.reshape(X,(m,1)) # reshape X to a vector
# X = np.c_[np.ones((m,1)),X] # insert column of ones

theta = zeros((2,1))

iterations = 1500
alpha = 0.01

cost = computeCost(X,Y,theta)

print cost

