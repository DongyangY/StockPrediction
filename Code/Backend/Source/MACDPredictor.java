package stockforecaster;

/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class MACDPredictor {

    private MACD macd;

    private List<Double> historicalData;
    private List<String> historicalDate;

    public void PredictAll() {
        historicalData = new ArrayList();
        historicalDate = new ArrayList();

        macd = new MACD();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                // Load history data of each company
                loadData(j);

                for (int i = 0; i < historicalData.size(); i++) {
                    List<Double> calculate = historicalData.subList(0, i + 1);
                    double emas = MACD.emaS(calculate);
                    double emal = MACD.emaL(calculate);
                    double dea = MACD.getDEA(calculate);
                    double dif = MACD.getDIF(calculate);
                    int f = MACD.getAction(calculate);
                    emas = Math.round(emas * 100.0) / 100.0;
                    emal = Math.round(emal * 100.0) / 100.0;
                    dea = Math.round(dea * 100.0) / 100.0;
                    dif = Math.round(dif * 100.0) / 100.0;

                    Statement stat = connection.createStatement();
                    stat.executeUpdate("INSERT INTO PredictionMACD VALUES ('" + StockForecaster.SYMBOLS[j] + "','" + historicalDate.get(i) + "'," + emas + "," + emal + "," + dea + "," + dif + "," + f + ")");
                }

            }

            connection.close();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    private void loadData(int CompanyIndex) {

        historicalData.clear();
        historicalDate.clear();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            ResultSet res = statement.executeQuery("SELECT * FROM StockHistorical WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "'");

            while (res.next()) {
                historicalData.add(res.getDouble("ClosePrice"));
                historicalDate.add(res.getString("Date"));
            }

            connection.close();

        } catch (Exception e) {
            System.out.println("database operation error 1.");
        }

    }
}
