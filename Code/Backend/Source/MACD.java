package stockforecaster;

/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */
import java.util.*;

public class MACD {

    private static double s = 12;
    private static double l = 26;
    private static double l12 = 2 / (s + 1);
    private static double l26 = 2 / (l + 1);

    private static Double emaS(List<Double> pricecls, int n) {
        Double emashort = (double) 0;
        if (n < 1) {
            return (double) 0;
        } else {
            emashort = emaS(pricecls, n - 1) * (1 - l12) + pricecls.get(n - 1) * l12;
        }
        return emashort;

    }

    public static Double emaS(List<Double> pricecls) {
        int m = pricecls.size();
        Double emashort = emaS(pricecls, m);
        return emashort;

    }

    private static Double emaL(List<Double> pricecls, int n) {
        Double emalong = (double) 0;
        if (n < 1) {
            return (double) 0;
        } else {
            emalong = emaL(pricecls, n - 1) * (1 - l26) + pricecls.get(n - 1) * l26;
        }
        return emalong;

    }

    public static Double emaL(List<Double> pricecls) {
        int m = pricecls.size();
        Double emalong = emaL(pricecls, m);
        return emalong;

    }

    public static Double getDIF(List<Double> pricecls) {
        Double diff = emaS(pricecls) - emaL(pricecls);
        return diff;
    }

    private static Double DIF(List<Double> pricecls, int index) {
        Double diff = emaS(pricecls, index) - emaL(pricecls, index);
        return diff;
    }

    public static Double getDEA(List<Double> pricecls) {
        int m = pricecls.size();
        Double dea = DEA(pricecls, m);
        return dea;
    }

    private static Double DEA(List<Double> pricecls, int n) {
        Double dea = (double) 0;
        if (n < 1) {
            return (double) 0;
        } else {
            dea = DEA(pricecls, n - 1) * 0.8 + DIF(pricecls, n) * 0.2;
        }
        return dea;
    }

    //0-hold 1-buy 2-buybuybuy 3-sell 4-sellsellsell
    public static int getAction(List<Double> pricecls) {
        int m = pricecls.size();
        int flag;
        Double deaT = getDEA(pricecls);
        Double difT = getDIF(pricecls);

        Double deaY = DEA(pricecls, m - 1);
        Double difY = DIF(pricecls, m - 1);

        if (((difY - deaY) < 0) && ((difT - deaT) > 0)) {
            flag = 1;
            if (difT > 0 & deaT > 0) {
                flag = 2;
            }
        } else if (((difY - deaY) > 0) && ((difT - deaT) < 0)) {
            flag = 3;
            if ((difT < 0) && (deaT < 0)) {
                flag = 4;
            }
        } else {
            flag = 0;
        }

        return flag;
    }
}
