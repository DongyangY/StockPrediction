/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

/*
 This file implements the Bayesian Curve Fitting algorithm
 Initialize the alpha, beta, M in contruction
 Calculate the mean, variance and the probility
 Input the Xn, the Tn, the test point X and the predict value
 If predict value is negtive, return the most possible T, i.e. the mean
 If predict value is user's guess, return the probility
    
 */
package stockforecaster;

import Jama.Matrix;

public class Bayesian {

    private double alpha;
    private double beta;
    private int polynomialOrder;

    // Initialize the parameter
    public Bayesian(double alpha, double beta, int polynomialOrder) {
        this.alpha = alpha;
        this.beta = beta;
        this.polynomialOrder = polynomialOrder;
    }

    // If predict value is negtive, return the most possible T, i.e. the mean
    // If predict value is user's guess, return the probility
    public double getPrediction(double[] trainningDataInput, double[] trainningDataOutput, double testInput, double predictValue) {

        // Check the data length of Xn and Tn
        if (trainningDataInput.length != trainningDataOutput.length) {
            System.out.println("the length of input and output trainning data should be the same.");
            System.exit(0);
        }

        int trainningDataLength = trainningDataInput.length;

        int matrixLength = polynomialOrder + 1;

        double[][] unitMatrixArray = new double[matrixLength][matrixLength];

        for (int i = 0; i < matrixLength; i++) {
            unitMatrixArray[i][i] = 1;
        }

        Matrix unitMatrix = new Matrix(unitMatrixArray);

        Matrix rowVectorOfTestInput = new Matrix(1, matrixLength, testInput);

        double[] columnVectorOfTranningDataInputArray = new double[matrixLength];

        for (int i = 0; i < matrixLength; i++) {
            double sum = 0;

            for (int j = 0; j < trainningDataLength; j++) {
                sum += Math.pow(trainningDataInput[j], i);
            }

            columnVectorOfTranningDataInputArray[i] = sum;
        }

        Matrix columnVectorOfTranningDataInput = new Matrix(columnVectorOfTranningDataInputArray, matrixLength);

        Matrix SInversePart1 = unitMatrix.times(alpha);
        Matrix SInversePart2 = columnVectorOfTranningDataInput.times(beta);
        SInversePart2 = SInversePart2.times(rowVectorOfTestInput);
        Matrix SInverse = SInversePart1.plus(SInversePart2);

        // Get the matrix S
        Matrix S = SInverse.inverse();

        double[] columnVectorOfTranningDataInputwithOutputArray = new double[matrixLength];

        for (int i = 0; i < matrixLength; i++) {
            double sum = 0;

            for (int j = 0; j < trainningDataLength; j++) {
                sum += Math.pow(trainningDataInput[j], i) * trainningDataOutput[j];
            }

            columnVectorOfTranningDataInputwithOutputArray[i] = sum;
        }

        Matrix columnVectorOfTranningDataInputwithOutput = new Matrix(columnVectorOfTranningDataInputwithOutputArray, matrixLength);

        Matrix mean = rowVectorOfTestInput.times(beta);
        mean = mean.times(S);
        mean = mean.times(columnVectorOfTranningDataInputwithOutput);

        // Get the mean
        double meanValue = mean.get(0, 0);

        if (predictValue < 0) {
            return meanValue;
        }

        Matrix columnVectorOfTestInput = new Matrix(matrixLength, 1, testInput);
        Matrix variance = rowVectorOfTestInput.times(S);
        variance = variance.times(columnVectorOfTestInput);
        double varianceValue = variance.get(0, 0);

        // Get the variance
        varianceValue += (1.0 / beta);

        System.out.println("mean: " + meanValue + "  variance: " + varianceValue);

        double possibility = 1.0 / Math.sqrt(2.0 * Math.PI * varianceValue);
        System.out.println(possibility);
        double exp = (predictValue - meanValue) * (predictValue - meanValue);
        exp *= (1.0 / (2.0 * varianceValue));

        // Get the probility
        possibility *= Math.exp(-exp);

        return possibility;

    }

}
