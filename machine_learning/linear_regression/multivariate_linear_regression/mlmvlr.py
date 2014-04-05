# adds feature normalization as well as multivariate
# functionality to linear regression


import sys

from numpy import *
import scipy as sp
from matplotlib import pyplot as plt, cm
from mpl_toolkits.mplot3d import Axes3D 

def featureNormalizeLoop( data ):
	"""Normalize the features using loop, this is the slower version"""
	mu 	      = []
	sigma 	  = []
	data_norm = zeros( shape(data), data.dtype )

	for col in range( 0, shape(data)[1] ):
		mu.append	( mean( data[:, col] ) )
		sigma.append( std ( data[:, col], ddof=1 ) ) # if ddof = 0 sigma will be uncorrected sample standard deviation
		data_norm[:, col] = map( lambda x: (x - mu[col]) / sigma[col], data[:, col] )

	return data_norm, array(mu), array( sigma )


def featureNormalize( data ):
	"""A vectorized version of feature normalization"""
	mu 			= mean( data, axis=0 )
	data_norm 	= data - mu
	sigma 		= std( data_norm, axis=0, ddof=1 )
	data_norm 	= data_norm / sigma
	return data_norm, mu, sigma


def gradientDescent( X, y, theta, alpha, iters, m ):
	"""Run a gradient descent"""
	grad  = copy( theta )
	max_j 		= shape(X)[1]
	J_history 	= []
	alpha_div_m = alpha / m

	for counter in range( 0, iters ):
		inner_sum 	= X.T.dot(X.dot( grad ) - y)
		grad 		= grad - alpha_div_m * inner_sum
		J_history.append( computeCost(X, y, grad, m ) )

	return J_history, grad


def computeCost( X, y, theta, m ):
	term = X.dot( theta ) - y
	return ( term.T.dot( term ) / (2 * m) )[0, 0]

def normalEquation( X, y ):
	return linalg.inv(X.T.dot( X )).dot( X.T ).dot( y )

data = genfromtxt("../ex1data2.txt",delimiter=",")

X = data[:,0:2]
Y = data[:,2:3]
m = shape(X)[0]

X,mu,sigma = featureNormalize(X)

print X
print mu
print sigma

X = c_[ones((m,1)),X]
iterations = 400
alphas = [0.01,0.03,0.06,0.1,1.0]

for alpha in alphas:
 	theta = zeros((3,1))
 	J_history, theta = gradientDescent( X, Y, theta, alpha, iterations, m )

 	number_of_iterations = array([x for x in range(1, iterations + 1)]).reshape(iterations,1)
 	plt.plot(number_of_iterations, J_history, 'b')
 	plt.title("Alpha = %f" % (alpha))
 	plt.xlabel('Number of iterations')
 	plt.ylabel('Cost J')
 	plt.xlim([0,50])
 	plt.show(block=True)

 	# 1650 sqft 3 bdrm house
 	test = array([1.0,1650,3.0])
 	#exclude intercept units
 	test[1:] = (test[1:]-mu) / sigma
 	print test.dot(theta)

theta = normalEquation(X,Y)
# 1650 sqft 3 bdrm
test = array([1.0,1650.0,3.0])
print test.dot(theta)

