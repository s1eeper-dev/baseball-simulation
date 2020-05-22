f1 = open("E:/School/DB/vs.txt","r")
f2 = open("E:/School/DB/du_vs.txt","w")

list_vs = []
for line in f1:
    fields = line.split("\t")
    P_ = fields[0]
    H_ = fields[1]
    PA = fields[2]
    AB = fields[3]
    H = fields[4]
    stock = (P_,H_,PA,AB,H[:-1])
    list_vs.append(stock)

for i in range(0, len(list_vs)):
    input_list = 'into VS values (' + list_vs[i][0] + ','+ list_vs[i][1] + ','+ list_vs[i][2] +','+ list_vs[i][3] +','+ list_vs[i][4] +')\n'
    f2.write(input_list)

f1.close()
f2.close()
