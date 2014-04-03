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

def gradientDescent(X,Y,theta,alpha,iterations):
	gradient = copy(theta)
	m = len(Y)

	for count in range(0,iterations):
		inner_sum = X.T.dot(hypothesis(X,gradient) -Y)
		gradient -= alpha / m * inner_sum

	return gradient

def gradientDescentLoop(X,Y,theta,alpha,iterations):
	gradient = copy(theta)
	m = len(Y)
	n = shape(X)[1]

	for count in range(0,iterations):
		# gets inner sums
		cumulative_innersum = [0 for x in range(0,n)]

		for j in range(0,n):
			for i in range(0,m):
				term = (hypothesis(X[i],gradient)-Y[i])
				cumulative_innersum[j] += X[i,j] * (term)

		for j in range(0,n):
			gradient[j] = gradient[j] - cumulative_innersum[j] * (alpha / m)

	return gradient


def plot(X,Y):
	plt.plot(X,Y,'rx',markersize=3)
	plt.ylabel("Profit in $10,000's")
	plt.xlabel("Population of city in 10,0")

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
hyp = hypothesis(X,theta)
descent = gradientDescent(X,Y,theta,alpha,iterations)

# print X
# print Y
# print theta
# print hyp
# print cost

print gradientDescentLoop(X,Y,theta,alpha,iterations)
print descent