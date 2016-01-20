// Linked List
struct Node;

typedef struct Node *PtrToNode;
typedef PtrToNode List;
typedef PtrToNode Position;

List MakeEmpty(List L);
int IsEmpty(List L);
int IsLast(Position P, List L);
Position Find(ElementType X, List L);
void Delete(ElementType X, List L);
Position FindPrevious(ElementType X, List L);
void Insert(ElementType X, List L, Position P);
void DeleteList(List L);
Position Header(List L);
Position First(List L);
Position Advance(Position P);
ElementType Retrieve(Position P);

struct Node{
    ElementType Element;
    Position Next;
}

int IsEmpty(List L){
    return L->Next == NULL;
}

int IsLast(Position P, List L){
    return P->Next == NULL;
}

Position Find(ElementType X, List L){
    Position P;

    P = L->Next;
    while(P != NULL && P->Element != X)
        P = P->Next;

    return P;
}

void Delete(ElementType X, List L){
    Position P, TmpCell;
    P = FindPrevious(X, L);
    if(!IsLast(P, L)){
        TmpCell = P->Next;
        P->Next = TmpCell->Next;
        free(TmpCell);
    }
}

Position FindPrevious(ElementType X, List L){
    Position P;
    P = L;
    while(P->Next != NULL && P->Next->Element != X){
        P = P->Next;
    }
    return P;
}

void Insert(ElementType X, List L, Position P){
    Position TmpCell;
    TmpCell = malloc(sizeof(struct Node));
    if(TmpCell == NULL){
        FatalError("No space");
    }
    TmpCell->Element = X;
    TmpCell->Next = P->Next;
    P->Next = TmpCell;
}

void DeleteList(List L){
    Position P, Tmp;

    P = L->Next;
    L->Next = NULL; // free header
    while(P != NULL){
        Tmp = P->Next;
        free(P);
        P = Tmp;
    }
}

/**
 * Doubly linked list
 * 双向链表
 */

/**
 * 循环链表
 * 双向循环链表
 */

/**
 * Demo of Linked List
 * 1. 一元多项式
 * 2. 线性时间的排序
 * 3. 课程注册
 */

/**
 * 1. 一元多项式
 */
define MaxDegree 5; // 多项式的最大阶
/** Polynomial ADT */
typedef struct{
    int CoeffArray[MaxDegree + 1];
    int HighPower;
} * Polynomial;

/** 多项式初始化为0 */
void ZeroPolynomial(Polynomial Poly){
    int i;
    for(i=0; i<=MaxDegree; i++)
        Poly->CoeffArray[i] = 0;
    Poly->HighPower = 0;
}

void AddPolynomial(const Polynomial Poly1,
    const Polynomial Poly2, Polynomial PolySum){
    int i;
    ZeroPolynomial(PolySum);
    PolySum->HighPower = Max(Poly1->HighPower, Poly2->HighPower);

    for(i=PolySum->HighPower; i>=0; i--){
        PolySum->CoeffArray[i] = Poly1->CoeffArray[i] + Poly2->CoeffArray[i];
    }
}

void MultPolynomial(const Polynomial Poly1,
    const Polynomial Poly2, Polynomial PolyProd){
    int i, j;
    ZeroPolynomial(PolyProd);
    PolyProd->HighPower = Poly1->HighPower + Poly2->HighPower;

    if(PolyPord->HighPower > MaxDegree)
        Error("Exceeded array size");
    else{
        for(i=0; i<=Poly1->HighPower; i++){
            for(j=0; j<= Poly2->HighPower; j++){
                PolyProd->CoeffArray[i+j] +=
                    Poly1->CoeffArray[i] +
                    Poly2->CoeffArray[j];
            }
        }
    }
}

// 多项式ADT链表实现的类型声明
typedef struct Node *PtrToNode

struct Node{
    int Coefficient;
    int Exponent;
    PrtToNode Next;
};

typedef PtrToNode Polynomial; /** Nodes sorted by exponent */


/**
 * 2. 基数排序: radix sort(card sort)
 *
 * bucket sort
 */

/**
 * 3. 邻接多重表:
 *
 * EG: n个学生注册m门课程,可以快速获得每个课程的注册者和每个学生的注册课程,同时可以快速相互定位.
 */
